<?php

namespace App\Console\Commands;

use App\Models\PackagePurchase;
use App\Models\Service;
use App\Traits\EmailTemplateTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeactivateExpiredPackages extends Command
{
    use EmailTemplateTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:deactivate-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Süresi dolan paketleri ve ilgili servisleri pasif yapar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Süresi dolan paketler kontrol ediliyor...');

        try {
            // Süresi dolmuş ve hala aktif olan paketleri bul
            $expiredPackages = PackagePurchase::where('status', 1)
                ->where('end_date', '<', now())
                ->with(['company', 'package', 'category'])
                ->get();

            if ($expiredPackages->isEmpty()) {
                $this->info('Süresi dolmuş aktif paket bulunamadı.');
                return Command::SUCCESS;
            }

            $this->info("Toplam {$expiredPackages->count()} süresi dolmuş paket bulundu.");

            $deactivatedCount = 0;
            $deactivatedServicesCount = 0;

            foreach ($expiredPackages as $package) {
                DB::beginTransaction();

                try {
                    // Paketi pasif yap
                    $package->update(['status' => 0]);

                    // Bu pakete ait servisleri pasif yap
                    $affectedServices = Service::where('company_id', $package->company_id)
                        ->where('category_id', $package->category_id)
                        ->where('status', 1)
                        ->update(['status' => 0]);

                    $deactivatedServicesCount += $affectedServices;

                    // Kullanıcıya bilgilendirme maili gönder
                    if ($package->company && $package->company->user) {
                        $this->triggerEmailTemplate('paket-suresi-doldu', $package->company->user, [
                            'company_name' => $package->company->name,
                            'package_name' => $package->package->title ?? 'Paket',
                            'category_name' => $package->category->name ?? 'Kategori',
                            'end_date' => \Carbon\Carbon::parse($package->end_date)->format('d.m.Y'),
                            'affected_services_count' => $affectedServices
                        ]);
                    }

                    DB::commit();

                    $deactivatedCount++;
                    $this->info("✓ Pasif yapıldı: {$package->company->name} - {$package->package->title} - {$package->category->name} ({$affectedServices} servis)");

                    Log::info('Süresi dolan paket pasif yapıldı', [
                        'package_id' => $package->id,
                        'company_id' => $package->company_id,
                        'company_name' => $package->company->name,
                        'package_name' => $package->package->title,
                        'category_name' => $package->category->name,
                        'end_date' => $package->end_date,
                        'affected_services' => $affectedServices
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->error("✗ Hata: {$package->company->name} - {$e->getMessage()}");

                    Log::error('Paket pasifleştirme hatası', [
                        'package_id' => $package->id,
                        'company_id' => $package->company_id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $this->info("\n=== İşlem Tamamlandı ===");
            $this->info("Pasif yapılan paket sayısı: {$deactivatedCount}");
            $this->info("Pasif yapılan servis sayısı: {$deactivatedServicesCount}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Genel hata: {$e->getMessage()}");
            Log::error('DeactivateExpiredPackages genel hatası', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Command::FAILURE;
        }
    }
}
