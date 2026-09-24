<?php
/**
 * Laravel Cache Temizleme Scripti
 * cPanel için - SSH gerektirmez
 *
 * Kullanım: https://yourdomain.com/clear-cache.php?password=your_password
 *
 * GÜVENLİK UYARISI: İşlem tamamlandıktan sonra bu dosyayı sunucudan silin!
 */

// =====================================================
// AYARLAR - BURADAN ŞİFRE BELİRLEYİN
// =====================================================
define('CLEAR_CACHE_PASSWORD', 'ev2025cache'); // ŞİFRENİZİ BURAYA YAZIN!
define('AUTO_DELETE_AFTER_USE', false); // true yaparsanız kullanımdan sonra kendini siler

// =====================================================
// GÜVENLİK KONTROLÜ
// =====================================================
$providedPassword = $_GET['password'] ?? '';

if ($providedPassword !== CLEAR_CACHE_PASSWORD) {
    http_response_code(403);
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Erişim Engellendi</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 50px; text-align: center; }
            .error { background: #ff4444; color: white; padding: 20px; border-radius: 5px; display: inline-block; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>❌ Erişim Engellendi</h2>
            <p>Geçersiz şifre! URL: <code>clear-cache.php?password=YOUR_PASSWORD</code></p>
        </div>
    </body>
    </html>
    ');
}

// =====================================================
// LARAVEL YOLU AYARLAMA
// =====================================================
$laravelPath = __DIR__ . '/laravel';

if (!is_dir($laravelPath)) {
    die('
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Laravel Bulunamadı</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 50px; text-align: center; }
            .error { background: #ff4444; color: white; padding: 20px; border-radius: 5px; display: inline-block; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>❌ Laravel Dizini Bulunamadı</h2>
            <p>Dizin: ' . $laravelPath . '</p>
            <p>Scripti Laravel root dizinine taşıyın veya $laravelPath değişkenini güncelleyin.</p>
        </div>
    </body>
    </html>
    ');
}

// =====================================================
// HELPER FONKSİYONLAR
// =====================================================
$results = [];

function runCommand($command, $description) {
    global $results, $laravelPath;

    $output = [];
    $return_var = 0;

    // Çalışma dizinini Laravel'e ayarla
    chdir($laravelPath);

    // Komutu çalıştır
    exec($command . ' 2>&1', $output, $return_var);

    $results[] = [
        'description' => $description,
        'command' => $command,
        'success' => $return_var === 0,
        'output' => implode("\n", $output),
        'return_code' => $return_var
    ];

    return $return_var === 0;
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }

    $files = array_diff(scandir($dir), ['.', '..', '.gitignore']);
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        is_dir($path) ? deleteDirectory($path) : unlink($path);
    }

    return true;
}

function checkDatabaseTable($tableName) {
    global $laravelPath, $results;

    try {
        // Laravel'in .env dosyasını oku
        $envPath = $laravelPath . '/.env';
        if (!file_exists($envPath)) {
            $results[] = [
                'description' => 'Veritabanı Kontrolü',
                'command' => 'Check DB Table: ' . $tableName,
                'success' => false,
                'output' => '.env dosyası bulunamadı',
                'return_code' => 1
            ];
            return false;
        }

        $env = file_get_contents($envPath);
        preg_match('/DB_HOST=(.*)/', $env, $host);
        preg_match('/DB_DATABASE=(.*)/', $env, $database);
        preg_match('/DB_USERNAME=(.*)/', $env, $username);
        preg_match('/DB_PASSWORD=(.*)/', $env, $password);

        $host = trim($host[1] ?? 'localhost');
        $database = trim($database[1] ?? '');
        $username = trim($username[1] ?? '');
        $password = trim($password[1] ?? '');

        if (empty($database)) {
            $results[] = [
                'description' => 'Veritabanı Kontrolü',
                'command' => 'Check DB Table: ' . $tableName,
                'success' => false,
                'output' => 'Veritabanı bilgileri eksik',
                'return_code' => 1
            ];
            return false;
        }

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            $results[] = [
                'description' => 'Veritabanı Kontrolü',
                'command' => 'Check DB Table: ' . $tableName,
                'success' => false,
                'output' => 'Veritabanı bağlantısı başarısız: ' . $conn->connect_error,
                'return_code' => 1
            ];
            return false;
        }

        $result = $conn->query("SHOW TABLES LIKE '$tableName'");
        $exists = $result && $result->num_rows > 0;

        $conn->close();

        $results[] = [
            'description' => 'Veritabanı Tablo Kontrolü',
            'command' => 'Check Table: ' . $tableName,
            'success' => $exists,
            'output' => $exists ? "✓ '$tableName' tablosu mevcut" : "✗ '$tableName' tablosu bulunamadı - Migration çalıştırın!",
            'return_code' => $exists ? 0 : 1
        ];

        return $exists;

    } catch (Exception $e) {
        $results[] = [
            'description' => 'Veritabanı Kontrolü',
            'command' => 'Check DB Table: ' . $tableName,
            'success' => false,
            'output' => 'Hata: ' . $e->getMessage(),
            'return_code' => 1
        ];
        return false;
    }
}

// =====================================================
// CACHE TEMİZLEME İŞLEMLERİ
// =====================================================
$startTime = microtime(true);

// PHP artisan kullanılabilir mi kontrol et
$phpPath = 'php'; // Bazı sunucularda 'php74', 'php80', 'php81' gibi versiyonlu olabilir

// 1. View Cache Temizle
runCommand("$phpPath artisan view:clear", "View Cache Temizleme");

// 2. Config Cache Temizle
runCommand("$phpPath artisan config:clear", "Config Cache Temizleme");

// 3. Route Cache Temizle
runCommand("$phpPath artisan route:clear", "Route Cache Temizleme");

// 4. Application Cache Temizle
runCommand("$phpPath artisan cache:clear", "Application Cache Temizleme");

// 5. Manuel Cache Dizinlerini Temizle (Artisan çalışmazsa)
$cacheDirectories = [
    $laravelPath . '/storage/framework/cache/data',
    $laravelPath . '/storage/framework/views',
    $laravelPath . '/bootstrap/cache'
];

foreach ($cacheDirectories as $dir) {
    if (is_dir($dir)) {
        $deleted = deleteDirectory($dir);
        $results[] = [
            'description' => 'Manuel Cache Temizleme',
            'command' => 'Delete: ' . basename(dirname($dir)) . '/' . basename($dir),
            'success' => $deleted,
            'output' => $deleted ? 'Dizin içeriği temizlendi' : 'Dizin temizlenemedi',
            'return_code' => $deleted ? 0 : 1
        ];

        // .gitignore dosyasını koru
        if ($deleted && basename($dir) === 'data') {
            @mkdir($dir, 0755, true);
            @file_put_contents($dir . '/.gitignore', '*' . PHP_EOL . '!.gitignore');
        }
    }
}

// 6. Composer Autoload Yenile
runCommand('composer dump-autoload --optimize', "Composer Autoload Yenileme");

// 7. Cache'leri Yeniden Oluştur
runCommand("$phpPath artisan config:cache", "Config Cache Yeniden Oluşturma");
runCommand("$phpPath artisan route:cache", "Route Cache Yeniden Oluşturma");

// 8. Storage İzinlerini Kontrol Et
$storageWritable = is_writable($laravelPath . '/storage');
$results[] = [
    'description' => 'Storage Dizini İzin Kontrolü',
    'command' => 'Check Permissions: storage/',
    'success' => $storageWritable,
    'output' => $storageWritable ? 'Storage dizini yazılabilir' : 'UYARI: Storage dizinine yazma izni yok! chmod 775 yapın',
    'return_code' => $storageWritable ? 0 : 1
];

// 9. Notifications Tablosu Kontrolü
checkDatabaseTable('notifications');

$endTime = microtime(true);
$executionTime = round($endTime - $startTime, 2);

// =====================================================
// SONUÇLARI GÖSTER
// =====================================================
$successCount = count(array_filter($results, fn($r) => $r['success']));
$totalCount = count($results);
$allSuccess = $successCount === $totalCount;

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Cache Temizleme - Sonuçlar</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: <?php echo $allSuccess ? '#10b981' : '#f59e0b'; ?>;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .header .stats {
            font-size: 18px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .summary {
            background: #f9fafb;
            border-left: 4px solid <?php echo $allSuccess ? '#10b981' : '#f59e0b'; ?>;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .summary h2 {
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .summary-item {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }
        .summary-item .label {
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-item .value {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        .result-item {
            background: #f9fafb;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .result-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }
        .result-item.failed {
            border-left-color: #ef4444;
            background: #fef2f2;
        }
        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .result-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-badge.success {
            background: #d1fae5;
            color: #065f46;
        }
        .status-badge.failed {
            background: #fee2e2;
            color: #991b1b;
        }
        .command {
            background: #1f2937;
            color: #10b981;
            padding: 12px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin: 10px 0;
            overflow-x: auto;
        }
        .output {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #4b5563;
            white-space: pre-wrap;
            margin-top: 10px;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
        }
        .warning-box {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            color: #92400e;
        }
        .warning-box h3 {
            margin-bottom: 10px;
            color: #78350f;
        }
        .icon {
            font-size: 24px;
        }
        .next-steps {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .next-steps h3 {
            color: #1e40af;
            margin-bottom: 15px;
        }
        .next-steps ol {
            margin-left: 20px;
            color: #1e3a8a;
        }
        .next-steps li {
            margin-bottom: 8px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo $allSuccess ? '✅ Tüm İşlemler Başarılı!' : '⚠️ Bazı İşlemler Tamamlanamadı'; ?></h1>
            <div class="stats">
                <?php echo $successCount; ?> / <?php echo $totalCount; ?> işlem başarılı •
                Süre: <?php echo $executionTime; ?> saniye
            </div>
        </div>

        <div class="content">
            <div class="summary">
                <h2>📊 Özet</h2>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Toplam İşlem</div>
                        <div class="value"><?php echo $totalCount; ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Başarılı</div>
                        <div class="value" style="color: #10b981;"><?php echo $successCount; ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Başarısız</div>
                        <div class="value" style="color: #ef4444;"><?php echo $totalCount - $successCount; ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Süre</div>
                        <div class="value" style="color: #3b82f6;"><?php echo $executionTime; ?>s</div>
                    </div>
                </div>
            </div>

            <h2 style="margin-bottom: 20px; color: #1f2937;">📋 Detaylı Sonuçlar</h2>

            <?php foreach ($results as $result): ?>
                <div class="result-item <?php echo $result['success'] ? '' : 'failed'; ?>">
                    <div class="result-header">
                        <div class="result-title">
                            <span class="icon"><?php echo $result['success'] ? '✅' : '❌'; ?></span>
                            <?php echo htmlspecialchars($result['description']); ?>
                        </div>
                        <span class="status-badge <?php echo $result['success'] ? 'success' : 'failed'; ?>">
                            <?php echo $result['success'] ? 'Başarılı' : 'Başarısız'; ?>
                        </span>
                    </div>
                    <div class="command">$ <?php echo htmlspecialchars($result['command']); ?></div>
                    <?php if (!empty($result['output'])): ?>
                        <div class="output"><?php echo htmlspecialchars($result['output']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <div class="next-steps">
                <h3>🎯 Sonraki Adımlar</h3>
                <ol>
                    <li><strong>Browser Cache Temizle:</strong> Ctrl+Shift+R (Windows) veya Cmd+Shift+R (Mac) ile hard refresh yapın</li>
                    <li><strong>Admin Paneli Test Et:</strong> Admin paneline giriş yapın ve sağ üstteki bildirim ikonunu kontrol edin</li>
                    <li><strong>Browser Console Kontrol:</strong> F12 tuşuna basıp Console sekmesinde JavaScript hatası var mı bakın</li>
                    <li><strong>Test Bildirimi:</strong> Yeni bir servis/fikir ekleyerek bildirim sisteminizi test edin</li>
                    <li><strong>Güvenlik:</strong> Bu dosyayı (clear-cache.php) sunucudan SİLİN!</li>
                </ol>
            </div>

            <?php if (!$allSuccess): ?>
                <div class="warning-box">
                    <h3>⚠️ Dikkat Gereken Noktalar</h3>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <?php
                        $failedResults = array_filter($results, fn($r) => !$r['success']);
                        foreach ($failedResults as $failed) {
                            echo '<li>' . htmlspecialchars($failed['description']) . ' başarısız oldu. Manuel olarak kontrol edin.</li>';
                        }
                        ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p><strong>Laravel Cache Temizleme Scripti</strong> • <?php echo date('d.m.Y H:i:s'); ?></p>
            <p style="margin-top: 5px; font-size: 12px;">⚠️ GÜVENLİK: İşleminiz tamamlandıktan sonra bu dosyayı sunucudan silin!</p>
        </div>
    </div>

    <?php if (AUTO_DELETE_AFTER_USE): ?>
        <script>
            console.log('✅ Cache temizleme tamamlandı!');
            console.log('🗑️ Script kendini silme modunda - dosya silinecek...');
        </script>
        <?php
        // Dosyayı sil
        @unlink(__FILE__);
        ?>
    <?php endif; ?>
</body>
</html>
