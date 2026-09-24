<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\PackagePurchase;
use App\Models\PackagePayment;
use App\Traits\EmailTemplateTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RenewExpiredPackages extends Command
{
    use EmailTemplateTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packages:renew-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatik yenileme aktif olan ve süresi biten paketleri yeniler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Süresi biten paketler kontrol ediliyor...');

        // Otomatik yenileme aktif olan ve utoken'ı olan şirketleri al
        $companies = Company::where('auto_renew', true)
            ->whereNotNull('utoken')
            ->where('utoken', '!=', '')
            ->where('status', 1)
            ->get();

        $this->info("Toplam {$companies->count()} şirket bulundu.");

        $renewedCount = 0;
        $failedCount = 0;

        foreach ($companies as $company) {
            // Şirketin aktif paketlerini kontrol et
            $expiredPackages = $company->purchasedPackages()
                ->where('end_date', '<=', now())
                ->get();

            if ($expiredPackages->isEmpty()) {
                continue; // Bu şirketin henüz süresi bitmemiş
            }

            $this->info("Şirket: {$company->name} - Süresi biten {$expiredPackages->count()} paket bulundu.");

            // Ödeme retry limiti kontrolü (maksimum 3 deneme)
            if ($company->payment_retry_count >= 3) {
                $this->warn("Şirket: {$company->name} - Maksimum deneme sayısına ulaşıldı. Otomatik yenileme durduruldu.");
                $company->update(['auto_renew' => false]);

                // Kullanıcıya email gönder
                if ($company->user) {
                    $this->triggerEmailTemplate('otomatik-yenileme-durdu', $company->user, [
                        'company_name' => $company->name,
                        'reason' => 'Ödeme başarısız oldu ve maksimum deneme sayısına ulaşıldı.'
                    ]);
                }
                continue;
            }

            // Her bir süresi biten paket için ödeme işlemi yap
            foreach ($expiredPackages as $expiredPackage) {
                try {
                    $result = $this->processRecurringPayment($company, $expiredPackage);

                    if ($result['success']) {
                        $renewedCount++;
                        $this->info("✓ Başarılı: {$company->name} - {$expiredPackage->category->name}");

                        // Başarılı ödeme sonrası retry count sıfırla
                        $company->update([
                            'payment_retry_count' => 0,
                            'last_payment_date' => now()
                        ]);
                    } else {
                        $failedCount++;
                        $this->error("✗ Başarısız: {$company->name} - {$result['message']}");

                        // Retry count artır
                        $company->increment('payment_retry_count');

                        // Kullanıcıya email gönder
                        if ($company->user) {
                            $this->triggerEmailTemplate('odeme-basarisiz', $company->user, [
                                'company_name' => $company->name,
                                'reason' => $result['message'],
                                'retry_count' => $company->payment_retry_count
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    $failedCount++;
                    $this->error("✗ Hata: {$company->name} - {$e->getMessage()}");
                    Log::error('Paket yenileme hatası', [
                        'company_id' => $company->id,
                        'package_id' => $expiredPackage->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $this->info("\n=== İşlem Tamamlandı ===");
        $this->info("Yenilenen paketler: {$renewedCount}");
        $this->info("Başarısız işlemler: {$failedCount}");

        return Command::SUCCESS;
    }

    /**
     * PayTR ile tekrarlayan ödeme işlemi
     */
    private function processRecurringPayment(Company $company, PackagePurchase $expiredPackage)
    {
        // PayTR API bilgileri
        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';

        // 1. Önce CAPI LIST ile ctoken alıyoruz
        $ctoken = $this->getCtoken($company->utoken, $merchant_id, $merchant_key, $merchant_salt);

        if (!$ctoken) {
            return [
                'success' => false,
                'message' => 'Kart token alınamadı. Kartınız geçersiz olabilir.'
            ];
        }

        // Müşteri bilgileri
        $email = $company->user->email ?? 'info@evhayaliniz.com';
        $user_name = $company->name;
        $user_address = $company->address ?? 'Adres bilgisi yok';
        $user_phone = $company->mobile_phone ?? '0000000000';

        // Yeni merchant_oid oluştur
        $merchant_oid = str_replace('.', '', microtime(true)) . mt_rand(1000, 9999);

        // Ödeme tutarı (kuruş cinsinden)
        $payment_amount = $expiredPackage->price * 100;

        // Sipariş sepeti
        $user_basket = base64_encode(json_encode([
            [
                $expiredPackage->package->title . ' - ' . $expiredPackage->category->name . ' (Yenileme)',
                $expiredPackage->price,
                1
            ]
        ]));

        // Kullanıcı IP (sunucu IP'si)
        $user_ip = $_SERVER['SERVER_ADDR'] ?? '85.34.78.112';

        $payment_type = 'card';
        $installment_count = '0';
        $currency = 'TL';
        $test_mode = '0';
        $non_3d = '1';
        $recurring_payment = '1';

        // Hash oluştur (Recurring payment için özel hash)
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count . $currency . $test_mode . $non_3d;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

        // API'ye gönderilecek veriler
        $post_vals = [
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_type' => $payment_type,
            'payment_amount' => $payment_amount,
            'currency' => $currency,
            'test_mode' => $test_mode,
            'non_3d' => $non_3d,
            'merchant_ok_url' => env('APP_URL') . '/odeme-basarili',
            'merchant_fail_url' => env('APP_URL') . '/odeme-basarisiz',
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'user_basket' => $user_basket,
            'debug_on' => '1',
            'client_lang' => 'tr',
            'paytr_token' => $paytr_token,
            'non3d_test_failed' => '0',
            'installment_count' => $installment_count,
            'card_type' => '',
            'recurring_payment' => $recurring_payment,
            'utoken' => $company->utoken,
            'ctoken' => $ctoken
        ];

        // cURL ile PayTR'ye istek gönder (Recurring payment için özel endpoint)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $result = @curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return [
                'success' => false,
                'message' => 'Ödeme gateway bağlantı hatası: ' . curl_error($ch)
            ];
        }

        curl_close($ch);
        $result = json_decode($result, true);

        // Sonucu kontrol et
        if (isset($result['status']) && $result['status'] == 'success') {
            // Eski paketi pasif yap
            $expiredPackage->update(['status' => 0]);

            // Yeni paket oluştur
            $newPackage = PackagePurchase::create([
                'company_id' => $company->id,
                'pro_package_id' => $expiredPackage->pro_package_id,
                'category_id' => $expiredPackage->category_id,
                'price' => $expiredPackage->price,
                'used_rights' => 0,
                'remaining_rights' => $expiredPackage->total_rights,
                'total_rights' => $expiredPackage->total_rights,
                'type' => $expiredPackage->type,
                'duration' => $expiredPackage->duration,
                'start_date' => now(),
                'end_date' => now()->addDays($expiredPackage->duration),
                'merchant_oid' => $merchant_oid,
                'status' => 1,
            ]);

            // Ödeme kaydı oluştur
            PackagePayment::create([
                'company_id' => $company->id,
                'pro_package_id' => $expiredPackage->pro_package_id,
                'amount' => $expiredPackage->price,
                'payment_status' => 'success'
            ]);

            // Şirketin package_id'sini güncelle
            $company->update(['package_id' => $newPackage->id]);

            // Başarılı ödeme email gönder
            if ($company->user) {
                $this->triggerEmailTemplate('odeme-onay', $company->user, [
                    'company_name' => $company->name,
                    'package_name' => $expiredPackage->package->title,
                    'amount' => $expiredPackage->price
                ]);
            }

            Log::info('Otomatik paket yenileme başarılı', [
                'company_id' => $company->id,
                'old_package_id' => $expiredPackage->id,
                'new_package_id' => $newPackage->id,
                'amount' => $expiredPackage->price
            ]);

            return [
                'success' => true,
                'message' => 'Paket başarıyla yenilendi',
                'new_package_id' => $newPackage->id
            ];
        } else {
            $errorMessage = $result['reason'] ?? 'Bilinmeyen hata';

            Log::error('Otomatik paket yenileme başarısız', [
                'company_id' => $company->id,
                'package_id' => $expiredPackage->id,
                'error' => $errorMessage
            ]);

            return [
                'success' => false,
                'message' => $errorMessage
            ];
        }
    }

    /**
     * CAPI LIST servisi ile ctoken alma
     */
    private function getCtoken($utoken, $merchant_id, $merchant_key, $merchant_salt)
    {
        // Hash oluştur
        $hash_str = $merchant_id . $utoken . $merchant_salt;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        // API'ye gönderilecek veriler
        $post_vals = [
            'merchant_id' => $merchant_id,
            'utoken' => $utoken,
            'paytr_token' => $paytr_token
        ];

        // cURL ile PayTR CAPI LIST servisine istek gönder
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/capi/list");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $result = @curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            Log::error('PayTR CAPI LIST hatası', ['error' => curl_error($ch)]);
            return null;
        }

        curl_close($ch);
        $result = json_decode($result, true);

        // Başarılı ise ilk kartın ctoken'ını döndür
        if (isset($result['status']) && $result['status'] == 'success' && !empty($result['cards'])) {
            return $result['cards'][0]['ctoken'] ?? null;
        }

        Log::error('PayTR CAPI LIST başarısız', ['response' => $result]);
        return null;
    }
}
