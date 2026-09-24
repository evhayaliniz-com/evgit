<?php
/**
 * Laravel Cache Temizleme Scripti (cPanel / Shared Hosting)
 * SSH ve exec() fonksiyonu gerektirmez!
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
    // Alternatif: Script zaten laravel içindeyse
    if (is_file(__DIR__ . '/artisan')) {
        $laravelPath = __DIR__;
    } else {
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
                <p>Mevcut dizin: ' . __DIR__ . '</p>
                <p>Aranan dizin: ' . $laravelPath . '</p>
                <p>Scripti Laravel root dizinine taşıyın.</p>
            </div>
        </body>
        </html>
        ');
    }
}

// =====================================================
// HELPER FONKSİYONLAR
// =====================================================
$results = [];
$startTime = microtime(true);

function addResult($description, $success, $output = '', $details = '') {
    global $results;
    $results[] = [
        'description' => $description,
        'success' => $success,
        'output' => $output,
        'details' => $details
    ];
    return $success;
}

function deleteDirectoryContents($dir, $keepGitignore = true) {
    if (!is_dir($dir)) {
        return ['success' => false, 'deleted' => 0, 'message' => 'Dizin bulunamadı'];
    }

    $deleted = 0;
    $errors = 0;

    $items = @scandir($dir);
    if ($items === false) {
        return ['success' => false, 'deleted' => 0, 'message' => 'Dizin okunamadı'];
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || ($keepGitignore && $item === '.gitignore')) {
            continue;
        }

        $path = $dir . '/' . $item;

        if (is_dir($path)) {
            $result = deleteDirectoryRecursive($path);
            if ($result['success']) {
                $deleted += $result['deleted'];
            } else {
                $errors++;
            }
        } else {
            if (@unlink($path)) {
                $deleted++;
            } else {
                $errors++;
            }
        }
    }

    return [
        'success' => $errors === 0,
        'deleted' => $deleted,
        'message' => $deleted . ' dosya/klasör silindi' . ($errors > 0 ? ', ' . $errors . ' hata' : '')
    ];
}

function deleteDirectoryRecursive($dir) {
    $deleted = 0;
    $errors = 0;

    $items = @scandir($dir);
    if ($items !== false) {
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;

            $path = $dir . '/' . $item;

            if (is_dir($path)) {
                $result = deleteDirectoryRecursive($path);
                $deleted += $result['deleted'];
                $errors += $result['success'] ? 0 : 1;
            } else {
                if (@unlink($path)) {
                    $deleted++;
                } else {
                    $errors++;
                }
            }
        }
    }

    if (@rmdir($dir)) {
        $deleted++;
    } else {
        $errors++;
    }

    return [
        'success' => $errors === 0,
        'deleted' => $deleted
    ];
}

function checkWritable($path) {
    return is_writable($path);
}

function checkDatabaseTable($tableName) {
    global $laravelPath;

    try {
        $envPath = $laravelPath . '/.env';
        if (!file_exists($envPath)) {
            return ['exists' => false, 'message' => '.env dosyası bulunamadı'];
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
            return ['exists' => false, 'message' => 'Veritabanı bilgileri eksik'];
        }

        $conn = @new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            return ['exists' => false, 'message' => 'DB bağlantısı başarısız: ' . $conn->connect_error];
        }

        $result = $conn->query("SHOW TABLES LIKE '$tableName'");
        $exists = $result && $result->num_rows > 0;

        $rowCount = 0;
        if ($exists) {
            $countResult = $conn->query("SELECT COUNT(*) as count FROM `$tableName`");
            if ($countResult) {
                $row = $countResult->fetch_assoc();
                $rowCount = $row['count'];
            }
        }

        $conn->close();

        return [
            'exists' => $exists,
            'message' => $exists ? "Tablo mevcut ($rowCount kayıt)" : 'Tablo bulunamadı - Migration gerekli!',
            'count' => $rowCount
        ];

    } catch (Exception $e) {
        return ['exists' => false, 'message' => 'Hata: ' . $e->getMessage()];
    }
}

function clearConfigCache($laravelPath) {
    $cacheFile = $laravelPath . '/bootstrap/cache/config.php';
    if (file_exists($cacheFile)) {
        return @unlink($cacheFile);
    }
    return true; // Zaten yok
}

function clearRoutesCache($laravelPath) {
    $cacheFile = $laravelPath . '/bootstrap/cache/routes-v7.php';
    $deleted = 0;

    // Laravel 11 için farklı route cache dosyaları olabilir
    $routeCacheFiles = [
        '/bootstrap/cache/routes-v7.php',
        '/bootstrap/cache/routes.php',
    ];

    foreach ($routeCacheFiles as $file) {
        $fullPath = $laravelPath . $file;
        if (file_exists($fullPath) && @unlink($fullPath)) {
            $deleted++;
        }
    }

    return $deleted > 0 || !file_exists($cacheFile);
}

// =====================================================
// CACHE TEMİZLEME İŞLEMLERİ
// =====================================================

// 1. View Cache Temizle
$viewCacheDir = $laravelPath . '/storage/framework/views';
$result = deleteDirectoryContents($viewCacheDir, true);
addResult(
    'View Cache Temizleme',
    $result['success'],
    $result['message'],
    'Dizin: storage/framework/views/'
);

// 2. Application Cache Temizle
$appCacheDir = $laravelPath . '/storage/framework/cache/data';
$result = deleteDirectoryContents($appCacheDir, true);
addResult(
    'Application Cache Temizleme',
    $result['success'],
    $result['message'],
    'Dizin: storage/framework/cache/data/'
);

// 3. Config Cache Temizle
$configCleared = clearConfigCache($laravelPath);
addResult(
    'Config Cache Temizleme',
    $configCleared,
    $configCleared ? 'Config cache dosyası silindi' : 'Config cache silinemedi veya zaten yok',
    'Dosya: bootstrap/cache/config.php'
);

// 4. Route Cache Temizle
$routesCleared = clearRoutesCache($laravelPath);
addResult(
    'Route Cache Temizleme',
    $routesCleared,
    $routesCleared ? 'Route cache dosyaları silindi' : 'Route cache silinemedi veya zaten yok',
    'Dosya: bootstrap/cache/routes-v7.php'
);

// 5. Session Dosyalarını Temizle (Opsiyonel)
$sessionDir = $laravelPath . '/storage/framework/sessions';
if (is_dir($sessionDir)) {
    $result = deleteDirectoryContents($sessionDir, true);
    addResult(
        'Session Temizleme',
        $result['success'],
        $result['message'],
        'Dizin: storage/framework/sessions/'
    );
}

// 6. Compiled Views Temizle
$compiledViewsDir = $laravelPath . '/storage/framework/views';
$viewFiles = @glob($compiledViewsDir . '/*.php');
$deletedViews = 0;
if ($viewFiles) {
    foreach ($viewFiles as $file) {
        if (@unlink($file)) {
            $deletedViews++;
        }
    }
}
addResult(
    'Compiled Views Temizleme',
    true,
    "$deletedViews compiled view dosyası silindi",
    'Dizin: storage/framework/views/*.php'
);

// 7. Storage İzinlerini Kontrol Et
$storageWritable = checkWritable($laravelPath . '/storage');
$cacheWritable = checkWritable($laravelPath . '/bootstrap/cache');
addResult(
    'Storage İzin Kontrolü',
    $storageWritable && $cacheWritable,
    'Storage: ' . ($storageWritable ? 'Yazılabilir ✓' : 'YAZILMIYOR! ✗') . ' | ' .
    'Cache: ' . ($cacheWritable ? 'Yazılabilir ✓' : 'YAZILMIYOR! ✗'),
    $storageWritable && $cacheWritable ? 'İzinler normal' : 'chmod 755 veya 775 yapın!'
);

// 8. .env Dosyası Kontrolü
$envExists = file_exists($laravelPath . '/.env');
addResult(
    '.env Dosyası Kontrolü',
    $envExists,
    $envExists ? '.env dosyası mevcut' : '.env dosyası BULUNAMADI!',
    $envExists ? 'Yapılandırma dosyası OK' : '.env.example dosyasını kopyalayın'
);

// 9. Autoload Dosyası Kontrolü
$autoloadPath = $laravelPath . '/vendor/autoload.php';
$autoloadExists = file_exists($autoloadPath);
addResult(
    'Composer Autoload Kontrolü',
    $autoloadExists,
    $autoloadExists ? 'Autoload dosyası mevcut' : 'Vendor klasörü YOK! composer install gerekli',
    $autoloadExists ? 'Composer bağımlılıkları yüklü' : 'composer install çalıştırın'
);

// 10. Helpers.php Kontrolü
$helpersPath = $laravelPath . '/app/helpers.php';
$helpersExists = file_exists($helpersPath);
addResult(
    'helpers.php Dosyası Kontrolü',
    $helpersExists,
    $helpersExists ? 'helpers.php dosyası mevcut ✓' : 'helpers.php dosyası BULUNAMADI!',
    $helpersExists ? 'user_notifications() fonksiyonu tanımlı olmalı' : 'Dosyayı sunucuya yükleyin!'
);

// 11. Notifications Tablosu Kontrolü
$dbCheck = checkDatabaseTable('notifications');
addResult(
    'Notifications Tablosu Kontrolü',
    $dbCheck['exists'],
    $dbCheck['message'],
    $dbCheck['exists'] ? 'Bildirim sistemi hazır' : 'phpMyAdmin\'den tabloyu oluşturun'
);

// 12. Notification Model Kontrolü
$notificationModelPath = $laravelPath . '/app/Models/Notification.php';
$notificationModelExists = file_exists($notificationModelPath);
addResult(
    'Notification Model Kontrolü',
    $notificationModelExists,
    $notificationModelExists ? 'Notification.php mevcut ✓' : 'Notification.php BULUNAMADI!',
    'Model: app/Models/Notification.php'
);

// 13. NotificationController Kontrolü
$notificationControllerPath = $laravelPath . '/app/Http/Controllers/Admin/NotificationController.php';
$notificationControllerExists = file_exists($notificationControllerPath);
addResult(
    'NotificationController Kontrolü',
    $notificationControllerExists,
    $notificationControllerExists ? 'NotificationController.php mevcut ✓' : 'NotificationController.php BULUNAMADI!',
    'Controller: app/Http/Controllers/Admin/NotificationController.php'
);

// 14. AdminNotificationTrait Kontrolü
$traitPath = $laravelPath . '/app/Traits/AdminNotificationTrait.php';
$traitExists = file_exists($traitPath);
addResult(
    'AdminNotificationTrait Kontrolü',
    $traitExists,
    $traitExists ? 'AdminNotificationTrait.php mevcut ✓' : 'AdminNotificationTrait.php BULUNAMADI!',
    'Trait: app/Traits/AdminNotificationTrait.php'
);

// 15. Admin Navbar View Kontrolü
$navbarPath = $laravelPath . '/resources/views/admin/inc/navbar.blade.php';
$navbarExists = file_exists($navbarPath);
if ($navbarExists) {
    $navbarContent = file_get_contents($navbarPath);
    $hasNotificationCode = strpos($navbarContent, 'user_notifications()') !== false;
    addResult(
        'Admin Navbar Bildirim Kodu Kontrolü',
        $hasNotificationCode,
        $hasNotificationCode ? 'Navbar\'da bildirim kodu mevcut ✓' : 'Navbar\'da bildirim kodu YOK!',
        'View: resources/views/admin/inc/navbar.blade.php'
    );
} else {
    addResult(
        'Admin Navbar Kontrolü',
        false,
        'navbar.blade.php BULUNAMADI!',
        'View: resources/views/admin/inc/navbar.blade.php'
    );
}

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
        .output {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 5px;
            font-size: 14px;
            color: #4b5563;
            margin-top: 8px;
        }
        .details {
            font-size: 12px;
            color: #6b7280;
            margin-top: 8px;
            font-style: italic;
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
        .info-box {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .info-box h4 {
            color: #1e40af;
            margin-bottom: 8px;
        }
        .info-box p {
            color: #1e3a8a;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo $allSuccess ? '✅ Cache Başarıyla Temizlendi!' : '⚠️ Bazı Kontroller Başarısız'; ?></h1>
            <div class="stats">
                <?php echo $successCount; ?> / <?php echo $totalCount; ?> kontrol başarılı •
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

            <div class="info-box">
                <h4>ℹ️ Bilgi: exec() Fonksiyonu Devre Dışı</h4>
                <p>Paylaşımlı hosting ortamında exec() fonksiyonu güvenlik nedeniyle kapalı. Bu normal bir durumdur. Script, dosya sistem işlemleri ile cache'leri temizledi. Artisan komutları yerine manuel temizlik yapıldı.</p>
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
                    <?php if (!empty($result['output'])): ?>
                        <div class="output"><?php echo htmlspecialchars($result['output']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($result['details'])): ?>
                        <div class="details"><?php echo htmlspecialchars($result['details']); ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <div class="next-steps">
                <h3>🎯 Sonraki Adımlar</h3>
                <ol>
                    <li><strong>Browser Cache Temizle:</strong> Ctrl+Shift+R (Windows) veya Cmd+Shift+R (Mac) ile hard refresh yapın</li>
                    <li><strong>Admin Paneli Test Et:</strong> Admin paneline giriş yapın ve sağ üstteki bildirim ikonunu kontrol edin</li>
                    <li><strong>Browser Console Kontrol:</strong> F12 tuşuna basıp Console sekmesinde JavaScript hatası var mı bakın</li>
                    <li><strong>Network Tab:</strong> F12 → Network sekmesinde <code>/admin/notifications/read</code> isteğini kontrol edin</li>
                    <li><strong>Test Bildirimi:</strong> Yeni bir servis/fikir/iletişim mesajı ekleyerek bildirim sisteminizi test edin</li>
                    <li><strong>Güvenlik:</strong> Bu dosyayı (clear-cache.php) sunucudan <strong>MUTLAKA SİLİN!</strong></li>
                </ol>
            </div>

            <?php
            $criticalFailed = array_filter($results, function($r) {
                return !$r['success'] && (
                    strpos($r['description'], 'helpers.php') !== false ||
                    strpos($r['description'], 'Notification Model') !== false ||
                    strpos($r['description'], 'NotificationController') !== false ||
                    strpos($r['description'], 'Notifications Tablosu') !== false
                );
            });
            ?>

            <?php if (count($criticalFailed) > 0): ?>
                <div class="warning-box">
                    <h3>⚠️ KRİTİK: Eksik Dosyalar Tespit Edildi!</h3>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <?php foreach ($criticalFailed as $failed): ?>
                            <li><strong><?php echo htmlspecialchars($failed['description']); ?>:</strong> <?php echo htmlspecialchars($failed['output']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p style="margin-top: 15px; font-weight: bold;">
                        Bu dosyalar olmadan bildirim sistemi çalışmaz! deployment/laravel/ klasöründen eksik dosyaları yükleyin.
                    </p>
                </div>
            <?php endif; ?>

            <?php
            $notificationTableMissing = array_filter($results, function($r) {
                return strpos($r['description'], 'Notifications Tablosu') !== false && !$r['success'];
            });
            ?>

            <?php if (count($notificationTableMissing) > 0): ?>
                <div class="warning-box">
                    <h3>🗄️ Notifications Tablosu Oluşturma SQL</h3>
                    <p>phpMyAdmin'e girin ve şu SQL'i çalıştırın:</p>
                    <pre style="background: #1f2937; color: #10b981; padding: 15px; border-radius: 5px; overflow-x: auto; margin-top: 10px; font-size: 12px;">CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `to_id` bigint(20) unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;</pre>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p><strong>Laravel Cache Temizleme Scripti v2.0</strong> (Shared Hosting Uyumlu)</p>
            <p style="margin-top: 5px;">Tarih: <?php echo date('d.m.Y H:i:s'); ?></p>
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

    <script>
        // Sayfa yüklendiğinde otomatik scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Başarısız işlemlere scroll
            const failedItems = document.querySelectorAll('.result-item.failed');
            if (failedItems.length > 0) {
                failedItems[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
</body>
</html>
