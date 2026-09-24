<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use File;

class ManualBackupController extends Controller
{
    /**
     * Yedekleme sayfasını gösterir.
     */
    public function index()
    {
        return view('backup.index');
    }

    /**
     * Gelen isteğe göre yedekleme işlemini yapar.
     */
    public function run(Request $request)
    {
        $request->validate([
            'type' => 'required|in:all,db,uploads,app,views,routes',
        ]);

        $type      = $request->input('type');
        $timestamp = now()->format('Ymd_His');
        $backupDir = $_SERVER['DOCUMENT_ROOT'] . '/backups';

        // Yedek klasörünü oluştur
        if (! File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        switch ($type) {
            case 'db':
                $this->backupDatabase($backupDir, $timestamp);
                break;

            case 'uploads':
                $this->zipFolder($_SERVER['DOCUMENT_ROOT'] . '/uploads', $backupDir, "uploads_{$timestamp}.zip");
                break;

            case 'app':
                $this->zipFolder(app_path(), $backupDir, "app_{$timestamp}.zip");
                break;

            case 'views':
                $this->zipFolder(resource_path('views'), $backupDir, "views_{$timestamp}.zip");
                break;

            case 'routes':
                $this->zipFolder(base_path('routes'), $backupDir, "routes_{$timestamp}.zip");
                break;

            case 'all':
            default:
                // 1) Veritabanı yedeği
                $this->backupDatabase($backupDir, $timestamp);
                // 2) Tüm dosyaları zip’le, backups klasörünü hariç tut
                $this->zipFolder(base_path(), $backupDir, "full_{$timestamp}.zip", ['backups']);
                break;
        }

        return back()->with('success', "Yedekleme tamamlandı: {$backupDir}");
    }

    /**
     * Saf PHP + PDO kullanarak tüm tablo yapısı ve verileri
     * tek bir .sql dosyasında oluşturur.
     */
    protected function backupDatabase(string $dir, string $timestamp)
    {
        $filePath = "{$dir}/db_{$timestamp}.sql";
        $pdo      = DB::connection()->getPdo();

        // Tüm tablo adlarını al
        $tables = $pdo
            ->query('SHOW TABLES')
            ->fetchAll(\PDO::FETCH_COLUMN);

        $sqlDump = '';
        foreach ($tables as $table) {
            // CREATE TABLE
            $row = $pdo
                ->query("SHOW CREATE TABLE `{$table}`")
                ->fetch(\PDO::FETCH_ASSOC);

            $sqlDump .= "{$row['Create Table']};\n\n";

            // Veri satırları
            $rows = $pdo
                ->query("SELECT * FROM `{$table}`")
                ->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($rows as $data) {
                $cols = array_map(fn($c) => "`{$c}`", array_keys($data));
                $vals = array_map(function($v) {
                    if (is_null($v)) return 'NULL';
                    return "'".str_replace("'", "\\'", $v)."'";
                }, array_values($data));

                $sqlDump .= "INSERT INTO `{$table}` (".implode(', ', $cols).") VALUES (".implode(', ', $vals).");\n";
            }

            $sqlDump .= "\n\n";
        }

        file_put_contents($filePath, $sqlDump);
    }

    /**
     * Belirtilen klasörü ZIP arşivine dönüştürür.
     * @param  string  $source       Kaynak klasör
     * @param  string  $destDir      Hedef yedek klasörü
     * @param  string  $zipName      Oluşacak ZIP dosya adı
     * @param  array   $exclude      Hariç tutulacak alt klasör adları
     */
    protected function zipFolder(string $source, string $destDir, string $zipName, array $exclude = [])
    {
        $zipPath = "{$destDir}/{$zipName}";
        $zip     = new ZipArchive;
        $zip->open($zipPath, ZipArchive::CREATE);

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if (! $file->isDir()) {
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($source) + 1);

                // Hariç tutulacak klasörleri atla
                foreach ($exclude as $ex) {
                    if (str_starts_with($relativePath, $ex . DIRECTORY_SEPARATOR)) {
                        continue 2;
                    }
                }

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
    }
}
