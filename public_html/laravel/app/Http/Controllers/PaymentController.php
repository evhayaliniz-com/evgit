<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PackagePayment;
use App\Models\PackagePurchase;
use App\Models\ProPackage;
use App\Models\ProPackageCategory;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\EmailTemplateTrait;

use App\Traits\NotificationTrait;

class PaymentController extends Controller
{

    use NotificationTrait, EmailTemplateTrait;

    public function index()
    {
        Log::info('PaymentController@index çağrıldı', [
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company->id ?? null
        ]);

        $price = session('total_price');
        $packageIds = session('pro_package_ids');
        $packageType = session('package_type');

        if (!$price || !$packageIds || !$packageType) {
            return redirect()->route('company.dashboard')->withError('İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }

        // Paketin bilgilerini alıyoruz.
        $package = ProPackageCategory::whereId($packageIds[0])->first();
        $package = $package->package;

        // Direkt API için gerekli bilgiler
        $company = auth()->user()->company;
        $packagePurchase = PackagePurchase::where('company_id', $company->id)
            ->where('status', 2)
            ->orderBy('id', 'desc')
            ->first();

        if (!$packagePurchase || !$packagePurchase->merchant_oid) {
            return redirect()->route('company.dashboard')->withError('İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }

        $merchant_oid = $packagePurchase->merchant_oid;

        // PayTR Direkt API için token üretimi (kart bilgileri OLMADAN)
        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';

        // IP adresi
        $user_ip = request()->ip();
        if (empty($user_ip) || $user_ip == '127.0.0.1') {
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }

        // Email
        $email = auth()->user()->email;

        // Kullanıcı bilgileri
        $user_name = $company->name ?? auth()->user()->name ?? 'Kullanıcı';
        $user_address = $company->address ?? 'Adres bilgisi yok';
        $user_phone = $company->phone ?? auth()->user()->phone ?? '05000000000';

        // Sepet bilgisi
        $user_basket = base64_encode(json_encode([
            [$package->title ?? 'Paket', number_format($price, 2, '.', ''), 1]
        ]));

        // Tutarı hesapla (TL cinsinden)
        // PayTR dokümantasyonuna göre payment_amount TL cinsinden gönderilmeli
        // "Ayraç olarak yalnızca nokta(.) gönderilmelidir" - örn: 5.00
        $payment_amount = number_format($price, 2, '.', '');

        // Kayıtlı kart var mı kontrol et
        $hasSavedCard = !empty($company->utoken);

        // PayTR Direkt API token üretimi
        // PayTR'nin "Bu işlemde 3D Secure kullanılmalıdır" hatası nedeniyle kayıtlı kart için de non_3d = "0" kullanıyoruz
        $payment_type = 'card';
        $installment_count = '0'; // Kayıtlı kart için her zaman Tek Çekim
        $currency = 'TL';
        $test_mode = '0';
        $non_3d = '0'; // Hem yeni kart hem kayıtlı kart için 3D Secure kullan

        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count . $currency . $test_mode . $non_3d . $merchant_salt;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        // Kayıtlı kart ve yeni kart için aynı token kullanılıyor (non_3d = "0")
        $paytr_token_new_card = $paytr_token;
        $paytr_token_saved_card = $paytr_token;

        Log::info('PaymentController@index - Token hesaplandı', [
            'hasSavedCard' => $hasSavedCard,
            'non_3d' => $non_3d,
            'installment_count' => $installment_count,
            'token_new_card' => $paytr_token_new_card,
            'token_saved_card' => $paytr_token_saved_card,
            'token_selected' => $paytr_token
        ]);

        Log::info('PaymentController@index - Kayıtlı kart kontrolü', [
            'company_id' => $company->id,
            'hasSavedCard' => $hasSavedCard,
            'utoken_exists' => !empty($company->utoken),
            'utoken_length' => strlen($company->utoken ?? ''),
            'utoken_preview' => substr($company->utoken ?? '', 0, 20) . '...'
        ]);

        // Kayıtlı kartları PayTR'den çek
        $savedCards = [];
        if ($hasSavedCard) {
            Log::info('PayTR CAPI LIST çağrısı başlatılıyor', [
                'company_id' => $company->id,
                'email' => $email,
                'utoken' => substr($company->utoken ?? '', 0, 20) . '...',
                'utoken_length' => strlen($company->utoken ?? '')
            ]);
            try {
                $savedCards = $this->getSavedCardsFromPayTR($email, $company->utoken);
                Log::info('PayTR CAPI LIST sonucu', [
                    'company_id' => $company->id,
                    'saved_cards_count' => count($savedCards),
                    'saved_cards' => $savedCards
                ]);
            } catch (\Exception $e) {
                Log::error('PayTR CAPI LIST exception', [
                    'company_id' => $company->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            Log::info('PayTR CAPI LIST çağrılmadı - hasSavedCard false', [
                'company_id' => $company->id,
                'utoken_exists' => !empty($company->utoken)
            ]);
        }

        // PayTR callback URL'leri
        $merchant_ok_url = route('payment.success');
        $merchant_fail_url = route('payment.error');

        return view('site.payment.index', compact(
            'price',
            'package',
            'merchant_oid',
            'hasSavedCard',
            'savedCards',
            'packageType',
            'merchant_id',
            'user_ip',
            'email',
            'payment_amount',
            'paytr_token_new_card',
            'paytr_token_saved_card',
            'payment_type',
            'currency',
            'test_mode',
            'non_3d',
            'user_name',
            'user_address',
            'user_phone',
            'user_basket',
            'paytr_token',
            'merchant_ok_url',
            'merchant_fail_url'
        ));
    }


    public function success()
    {
        // Başarılı ödeme sonrası kullanıcıyı bilgilendirme sayfası
        return view('site.payment.odeme-basarili');
    }

    public function error()
    {
        // Başarısız ödeme sonrası kullanıcıyı bilgilendirme sayfası
        return view('site.payment.odeme-basarisiz');
    }

    /**
     * Installment count veya payment method değiştiğinde token'ı yeniden hesapla
     * PayTR dokümantasyonuna göre token ve form'daki installment_count aynı olmalı
     * Kayıtlı kart seçildiğinde hash hesaplaması farklı olur (utoken kullanılır)
     */
    public function recalculateToken(Request $request)
    {
        $request->validate([
            'merchant_oid' => 'required|string',
            'installment_count' => 'required|integer|min:0|max:12',
            'use_saved_card' => 'nullable|boolean',
            'utoken' => 'nullable|string',
        ]);

        $company = auth()->user()->company;
        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';

        // Paket bilgilerini al
        $packagePurchase = PackagePurchase::where('merchant_oid', $request->merchant_oid)
            ->where('company_id', $company->id)
            ->where('status', 2)
            ->first();

        if (!$packagePurchase) {
            return response()->json(['status' => 'error', 'message' => 'Paket bulunamadı'], 404);
        }

        // IP adresi
        $user_ip = request()->ip();
        if (empty($user_ip) || $user_ip == '127.0.0.1') {
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }

        // Email
        $email = auth()->user()->email;

        // Sepet bilgisi
        $package = $packagePurchase->package;
        $user_basket = base64_encode(json_encode([
            [$package->title ?? 'Paket', number_format($packagePurchase->price, 2, '.', ''), 1]
        ]));

        // Tutarı hesapla (TL cinsinden)
        $payment_amount = number_format($packagePurchase->price, 2, '.', '');

        // PayTR Direkt API token üretimi
        $payment_type = 'card';
        $installment_count = (string)$request->installment_count;
        $currency = 'TL';
        $test_mode = '0';
        $non_3d = '0';

        // PayTR dokümantasyonuna göre: Kayıtlı karttan ödeme için token hesaplaması normal token hesaplaması gibi
        // merchant_id + user_ip + merchant_oid + email + payment_amount + payment_type + installment_count + currency + test_mode + non_3d + merchant_salt
        // Kayıtlı kart kullanılıyorsa sadece utoken ve ctoken gönderilir, token hesaplaması aynı kalır
        $use_saved_card = $request->use_saved_card && !empty($request->utoken);

        // Kayıtlı kart için non_3d = "1" olmalı
        if ($use_saved_card) {
            $non_3d = '1';
        }

        // Token hesaplaması her zaman aynı (PayTR dokümantasyonuna göre)
        $hash_str = $merchant_id . $user_ip . $request->merchant_oid . $email . $payment_amount . $payment_type . $installment_count . $currency . $test_mode . $non_3d . $merchant_salt;

        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        Log::info('PayTR Token yeniden hesaplandı', [
            'use_saved_card' => $use_saved_card,
            'non_3d' => $non_3d,
            'installment_count' => $installment_count,
            'hash_str_length' => strlen($hash_str),
            'token_length' => strlen($paytr_token)
        ]);

        return response()->json([
            'status' => 'success',
            'paytr_token' => $paytr_token
        ]);
    }

    /**
     * Direkt API ile ödeme işlemi
     * PayTR Direkt API kullanarak Non3D ödeme alır
     */
    public function processDirectPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'merchant_oid' => 'required|string',
                'card_number' => 'required|string|min:16|max:19',
                'card_month' => 'required|string|size:2',
                'card_year' => 'required|string|size:2',
                'card_cvv' => 'required|string|size:3',
                'card_name' => 'required|string|max:50',
                'installment' => 'required|integer|min:1|max:12',
                'store_card' => 'nullable|boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Payment validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Form verilerinde hata var: ' . implode(', ', array_map(function ($errors) {
                    return implode(', ', $errors);
                }, $e->errors()))
            ], 400);
        }

        $company = auth()->user()->company;
        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';

        // Paket bilgilerini al
        $package = PackagePurchase::where('merchant_oid', $request->merchant_oid)
            ->where('company_id', $company->id)
            ->where('status', 2)
            ->first();

        if (!$package) {
            return response()->json(['status' => 'error', 'message' => 'Paket bulunamadı'], 404);
        }

        // Tutarı hesapla (kuruş cinsinden)
        $payment_amount = ($package->price * 100);

        // Taksit varsa vade farkı ekle
        if ($request->installment > 1) {
            // Taksit oranı %2 (örnek, PayTR'den alınmalı)
            $installment_rate = 2; // PayTR'den alınacak gerçek oran
            $payment_amount = $payment_amount / ((100 - $installment_rate) / 100);
        }

        // Kart bilgilerini temizle (sadece rakamlar)
        $card_number = preg_replace('/\D/', '', $request->card_number);
        $card_month = $request->card_month;
        $card_year = '20' . $request->card_year;
        $card_cvv = $request->card_cvv;
        $card_name = $request->card_name;

        // IP adresi
        $user_ip = request()->ip();
        if (empty($user_ip) || $user_ip == '127.0.0.1') {
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }

        // Email
        $email = auth()->user()->email;

        // Kullanıcı bilgileri (PayTR Direkt API için zorunlu)
        $user_name = $company->name ?? auth()->user()->name ?? 'Kullanıcı';
        $user_address = $company->address ?? 'Adres bilgisi yok';
        $user_phone = $company->phone ?? auth()->user()->phone ?? '05000000000';

        // Sepet bilgisi
        $user_basket = base64_encode(json_encode([
            [$package->package->title ?? 'Paket', number_format($package->price, 2, '.', ''), 1]
        ]));

        // Hash hesaplama (Direkt API için)
        // PayTR dokümantasyonuna göre: merchant_id + user_ip + merchant_oid + email + payment_amount + user_basket + installment_count + card_number + expiry_month + expiry_year + cvv + cc_owner + store_card + merchant_salt
        // NOT: user_name, user_address, user_phone hash'e dahil DEĞİL (sadece POST'ta gönderilir)
        // NOT: utoken hash'e dahil DEĞİL (sadece kayıtlı karttan ödeme yapılırken POST'ta gönderilir)
        // ÖNEMLİ: Tüm değerler string olarak birleştirilmeli
        $installment_count = (string)$request->installment;
        $payment_amount_str = (string)(int)$payment_amount; // Kuruş cinsinden, integer olarak
        $store_card_str = $request->store_card ? '1' : '0';

        // Hash string oluştur (PayTR Direkt API formatına göre - yeni kart ile ödeme)
        $hash_str = $merchant_id . $user_ip . $request->merchant_oid . $email . $payment_amount_str . $user_basket . $installment_count . $card_number . $card_month . $card_year . $card_cvv . $card_name . $store_card_str . $merchant_salt;
        $hash = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        // Hash hesaplama debug
        Log::info('PayTR Direct API Hash Calculation', [
            'merchant_oid' => $request->merchant_oid,
            'hash_components' => [
                'merchant_id' => $merchant_id,
                'user_ip' => $user_ip,
                'merchant_oid' => $request->merchant_oid,
                'email' => $email,
                'payment_amount' => $payment_amount_str,
                'user_basket' => $user_basket,
                'installment_count' => $installment_count,
                'card_number' => substr($card_number, 0, 4) . '****' . substr($card_number, -4),
                'expiry_month' => $card_month,
                'expiry_year' => $card_year,
                'cvv' => '***',
                'cc_owner' => $card_name,
                'store_card' => $store_card_str,
                'merchant_salt' => $merchant_salt
            ],
            'hash_str_preview' => substr($hash_str, 0, 100) . '...' . substr($hash_str, -50),
            'hash_str_length' => strlen($hash_str),
            'hash_length' => strlen($hash),
            'hash_preview' => substr($hash, 0, 20) . '...',
            'full_hash' => $hash,
            'note' => 'Yeni kart ile ödeme - utoken hash\'e dahil değil'
        ]);

        // POST verileri (PayTR Direkt API formatına göre - yeni kart ile ödeme)
        // NOT: Utoken sadece kart saklama için kullanılıyor, ödeme için değil
        // Her zaman yeni kart bilgileri gönderiliyor (formdan geliyor)
        $post_vals = [
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $request->merchant_oid,
            'email' => $email,
            'payment_amount' => (int)$payment_amount,
            'paytr_token' => $hash,
            'user_basket' => $user_basket,
            'installment_count' => $request->installment,
            'currency' => 'TL',
            'test_mode' => 0,
            'non_3d' => 1, // Non3D ödeme
            'card_type' => 'credit',
            'cc_owner' => $card_name,
            'card_number' => $card_number,
            'expiry_month' => $card_month,
            'expiry_year' => $card_year,
            'cvv' => $card_cvv,
            'store_card' => $request->store_card ? 1 : 0,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => route('payment.success'),
            'merchant_fail_url' => route('payment.error'),
            'timeout_limit' => 30, // PayTR Direkt API için timeout (saniye)
            'lang' => 'tr', // Dil parametresi
        ];

        // utoken sadece varsa ekle (boş string gönderme)
        // NOT: utoken kart saklama için kullanılıyor, ödeme için değil
        // PayTR callback'den utoken gelecek ve kaydedilecek
        // Şu anki senaryoda her zaman yeni kart bilgileri gönderiliyor, bu yüzden utoken POST'ta gönderilmez

        // Request'i logla
        Log::info('PayTR Direct API Request', [
            'merchant_oid' => $request->merchant_oid,
            'post_vals' => array_merge($post_vals, [
                'card_number' => substr($card_number, 0, 4) . '****' . substr($card_number, -4), // Güvenlik için
                'cvv' => '***'
            ]),
            'hash_str_length' => strlen($hash_str),
            'payment_amount' => $payment_amount
        ]);

        // PayTR Direkt API'ye istek gönder
        $ch = curl_init();
        $post_data = http_build_query($post_vals);

        Log::info('PayTR Direct API cURL Request Details', [
            'merchant_oid' => $request->merchant_oid,
            'url' => 'https://www.paytr.com/odeme/api/direkt-api',
            'post_data_length' => strlen($post_data),
            'post_data_preview' => substr($post_data, 0, 200) . '...'
        ]);

        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/direkt-api");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_VERBOSE, false); // Verbose mode (sadece debug için)
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (compatible; PayTR-Integration)'
        ]);

        $result = curl_exec($ch);
        $curl_error = curl_errno($ch);
        $curl_error_msg = $curl_error ? curl_error($ch) : null;
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_info = curl_getinfo($ch);
        curl_close($ch);

        // Detaylı cURL bilgilerini logla
        Log::info('PayTR Direct API cURL Info', [
            'merchant_oid' => $request->merchant_oid,
            'curl_error' => $curl_error,
            'curl_error_msg' => $curl_error_msg,
            'http_code' => $http_code,
            'url' => $curl_info['url'] ?? null,
            'total_time' => $curl_info['total_time'] ?? null,
            'connect_time' => $curl_info['connect_time'] ?? null,
            'result_length' => strlen($result ?? ''),
            'result_preview' => substr($result ?? '', 0, 500)
        ]);

        // Log kaydet
        try {
            DB::table('paytr_logs')->insert([
                'type' => 'direct_api_payment',
                'request_data' => json_encode($post_vals, JSON_UNESCAPED_UNICODE),
                'response_data' => json_encode(['raw_response' => $result, 'http_code' => $http_code], JSON_UNESCAPED_UNICODE),
                'merchant_oid' => $request->merchant_oid,
                'status' => $curl_error ? 'error' : 'success',
                'error_message' => $curl_error ? 'CURL Hatası: ' . $curl_error_msg : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('PaytrLog Direct API DB Hatası', ['error' => $e->getMessage()]);
        }

        if ($curl_error) {
            Log::error('PayTR Direct API CURL Hatası', [
                'error_code' => $curl_error,
                'error_message' => $curl_error_msg,
                'merchant_oid' => $request->merchant_oid
            ]);
            return response()->json(['status' => 'error', 'message' => 'Ödeme sistemi ile bağlantı kurulamadı'], 500);
        }

        // Raw yanıtı logla (ilk 1000 karakter)
        Log::info('PayTR Direct API Raw Response', [
            'merchant_oid' => $request->merchant_oid,
            'raw_response_preview' => substr($result ?? '', 0, 1000),
            'raw_response_length' => strlen($result ?? ''),
            'http_code' => $http_code,
            'content_type' => $curl_info['content_type'] ?? null,
            'is_json' => !empty($result) && (substr(trim($result), 0, 1) === '{' || substr(trim($result), 0, 1) === '[')
        ]);

        if (empty($result)) {
            // HTTP status code'a göre daha detaylı hata mesajı
            $error_message = 'PayTR\'den yanıt alınamadı';
            if ($http_code >= 400 && $http_code < 500) {
                $error_message = 'PayTR API: İstek hatası (HTTP ' . $http_code . ')';
            } elseif ($http_code >= 500) {
                $error_message = 'PayTR API: Sunucu hatası (HTTP ' . $http_code . ')';
            } elseif ($http_code == 0) {
                $error_message = 'PayTR API: Bağlantı kurulamadı (timeout veya DNS hatası)';
            }

            Log::error('PayTR Direct API Boş Yanıt', [
                'merchant_oid' => $request->merchant_oid,
                'http_code' => $http_code,
                'curl_error' => $curl_error,
                'curl_error_msg' => $curl_error_msg,
                'url' => $curl_info['url'] ?? null,
                'total_time' => $curl_info['total_time'] ?? null,
                'connect_time' => $curl_info['connect_time'] ?? null,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $error_message,
                'debug' => [
                    'http_code' => $http_code,
                    'curl_error' => $curl_error,
                    'curl_error_msg' => $curl_error_msg
                ]
            ], 400);
        }

        $result = json_decode($result, true);

        // JSON decode hatası kontrolü
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('PayTR Direct API JSON Decode Hatası', [
                'merchant_oid' => $request->merchant_oid,
                'json_error' => json_last_error_msg(),
                'raw_response' => $result
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'PayTR yanıtı işlenemedi'
            ], 400);
        }

        Log::info('PayTR Direct API Response', [
            'merchant_oid' => $request->merchant_oid,
            'status' => $result['status'] ?? 'unknown',
            'response' => $result
        ]);

        if (isset($result['status']) && $result['status'] === 'success') {
            // Başarılı - Callback otomatik olarak çağrılacak
            return response()->json([
                'status' => 'success',
                'message' => 'Ödeme başarıyla alındı',
                'redirect_url' => route('payment.success')
            ]);
        } else {
            // Başarısız
            $error_message = $result['reason'] ?? $result['err_msg'] ?? $result['error'] ?? 'Ödeme işlemi başarısız';
            Log::error('PayTR Direct API Ödeme Hatası', [
                'merchant_oid' => $request->merchant_oid,
                'error_message' => $error_message,
                'full_response' => $result
            ]);
            return response()->json([
                'status' => 'error',
                'message' => $error_message
            ], 400);
        }
    }



    public function transactions()
    {


        ## 2. ADIM için örnek kodlar ##

        ## ÖNEMLİ UYARILAR ##
        ## 1) Bu sayfaya oturum (SESSION) ile veri taşıyamazsınız. Çünkü bu sayfa müşterilerin yönlendirildiği bir sayfa değildir.
        ## 2) Entegrasyonun 1. ADIM'ında gönderdiğniz merchant_oid değeri bu sayfaya POST ile gelir. Bu değeri kullanarak
        ## veri tabanınızdan ilgili siparişi tespit edip onaylamalı veya iptal etmelisiniz.
        ## 3) Aynı sipariş için birden fazla bildirim ulaşabilir (Ağ bağlantı sorunları vb. nedeniyle). Bu nedenle öncelikle
        ## siparişin durumunu veri tabanınızdan kontrol edin, eğer onaylandıysa tekrar işlem yapmayın. Örneği aşağıda bulunmaktadır.

        $post = request()->all();

        // Callback'i paytr_logs'a kaydet (TÜM POST VERİLERİNİ)
        try {
            DB::table('paytr_logs')->insert([
                'type' => 'callback',
                'request_data' => json_encode($post, JSON_UNESCAPED_UNICODE),
                'response_data' => null,
                'merchant_oid' => $post['merchant_oid'] ?? null,
                'status' => $post['status'] ?? 'unknown',
                'error_message' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('PaytrLog Callback DB Hatası', ['error' => $e->getMessage()]);
        }

        Log::info('PayTR callback received', [
            'merchant_oid' => $post['merchant_oid'] ?? null,
            'status' => $post['status'] ?? null,
            'total_amount' => $post['total_amount'] ?? null,
            'utoken' => $post['utoken'] ?? 'NOT_SET',
            'card_token' => $post['card_token'] ?? 'NOT_SET',
            'all_post_keys' => array_keys($post),
            'ip' => request()->ip(),
            'note' => 'Direkt API kullanılıyor: utoken callback\'de gelir'
        ]);
        // $post = $_POST;

        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - PayTR Mağaza Paneli > Bilgi sayfasından alın
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';
        Log::info('PayTR merchant credentials', [
            'merchant_key_length' => strlen($merchant_key),
            'merchant_salt_length' => strlen($merchant_salt),
            'merchant_key_empty' => empty($merchant_key),
            'merchant_salt_empty' => empty($merchant_salt),
        ]);
        ###########################################################################

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. ########
        ## POST değerleri ile hash oluştur.
        // $hash = base64_encode(hash_hmac('sha256', $request->merchant_oid . $merchant_salt . $request->status . $request->total_amount, $merchant_key, true));

        if (!isset($post['merchant_oid'], $post['status'], $post['total_amount'], $post['hash'])) {
            Log::error('PayTR callback missing required fields', [
                'received_fields' => array_keys($post),
            ]);
            echo 'PAYTR notification failed: missing fields';
            exit;
        }

        // PayTR dokümanına göre hash hesaplama: merchant_oid + merchant_salt + status + total_amount
        $paytr_token = $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'];
        $hash = base64_encode(hash_hmac('sha256', $paytr_token, $merchant_key, true));

        Log::info('PayTR hash calculation debug', [
            'merchant_oid' => $post['merchant_oid'],
            'merchant_salt' => $merchant_salt,
            'status' => $post['status'],
            'total_amount' => $post['total_amount'],
            'paytr_token' => $paytr_token,
            'computed_hash' => $hash,
            'received_hash' => $post['hash'] ?? null,
        ]);


        #
        ## Oluşturulan hash'i, paytr'dan gelen post içindeki hash ile karşılaştır (isteğin paytr'dan geldiğine ve değişmediğine emin olmak için)
        ## Bu işlemi yapmazsanız maddi zarara uğramanız olasıdır.
        // if ($hash != $request->hash) {
        if ($hash != $post['hash']) {
            Log::error('PayTR hash mismatch', [
                'computed_hash' => $hash,
                'received_hash' => $post['hash'],
                'merchant_oid' => $post['merchant_oid'],
            ]);
            die('PAYTR notification failed: bad hash');
        }

        ###########################################################################

        ## BURADA YAPILMASI GEREKENLER
        ## 1) Siparişin durumunu $post['merchant_oid'] değerini kullanarak veri tabanınızdan sorgulayın.
        ## 2) Eğer sipariş zaten daha önceden onaylandıysa veya iptal edildiyse  echo "OK"; exit; yaparak sonlandırın.

        /* Sipariş durum sorgulama örnek
           $durum = SQL
           if($durum == "onay" || $durum == "iptal"){
                echo "OK";
                exit;
            }
         */

        // if ($request->status == 'success') { ## Ödeme Onaylandı
        if ($post['status'] == 'success') { ## Ödeme Onaylandı

            Log::info('PayTR payment success processing', [
                'merchant_oid' => $post['merchant_oid'],
                'total_amount' => $post['total_amount'],
            ]);

            // Satın alınan paketin verilerini çekiyoruz.
            $package = PackagePurchase::where('merchant_oid', $post['merchant_oid'])->where('status', 2)->first();

            if (!$package) {
                Log::error('PayTR package not found', [
                    'merchant_oid' => $post['merchant_oid'],
                ]);
                echo "OK"; // PayTR'ye başarılı bildirim gönder
                exit;
            }

            if ($package) {
                $company = Company::whereId($package->company_id)->first();

                if (!$company) {
                    Log::error('PayTR company not found', [
                        'company_id' => $package->company_id,
                        'merchant_oid' => $post['merchant_oid'],
                    ]);
                    echo "OK"; // PayTR'ye başarılı bildirim gönder
                    exit;
                }

                if ($company->package_id) {
                    // Kullanıcının var olan paketini pasif yapıyoruz.
                    PackagePurchase::whereId($company->package_id)->where('company_id', $company->id)->update(['status' => 0]);
                }


                // Satın alınan paketi aktif yapıyoruz.
                PackagePurchase::where('merchant_oid', $post['merchant_oid'])->where('status', 2)->update(['status' => 1]);

                // Firmanın verilerini güncelliyoruz.
                $companyUpdateData = ['last_payment_date' => now(), 'payment_retry_count' => 0];

                // Direkt API kullanılıyor - utoken callback'de gelir
                $utokenSource = null;

                Log::info('Callback: utoken kontrolü başlatılıyor (Direkt API)', [
                    'company_id' => $company->id,
                    'db_utoken_exists' => !empty($company->utoken),
                    'db_utoken_length' => strlen($company->utoken ?? ''),
                    'callback_utoken_exists' => isset($post['utoken']) && !empty($post['utoken'])
                ]);

                // Direkt API'de utoken callback'de gelir
                if (isset($post['utoken']) && !empty($post['utoken'])) {
                    // Callback'den gelen utoken'ı kaydet
                    $companyUpdateData['utoken'] = $post['utoken'];
                    $utokenSource = 'callback_direct_api';
                    Log::info('Callback: utoken from callback (Direkt API)', [
                        'company_id' => $company->id,
                        'utoken_length' => strlen($post['utoken'])
                    ]);
                } elseif (!empty($company->utoken)) {
                    // DB'de zaten utoken var, güncellemeye gerek yok
                    $utokenSource = 'existing_db';
                    Log::info('Callback: utoken already exists in DB', [
                        'company_id' => $company->id,
                        'utoken_length' => strlen($company->utoken)
                    ]);
                } else {
                    // utoken gelmemiş (kart saklanmamış olabilir)
                    $utokenSource = 'not_provided';
                    Log::info('Callback: utoken not provided (kart saklanmamış olabilir)', [
                        'company_id' => $company->id
                    ]);
                }

                Company::whereId($company->id)->update($companyUpdateData);

                // Callback logunu güncelle (utoken bilgisi ile)
                try {
                    DB::table('paytr_logs')
                        ->where('type', 'callback')
                        ->where('merchant_oid', $post['merchant_oid'])
                        ->update([
                            'response_data' => json_encode([
                                'status' => 'processed',
                                'company_id' => $company->id,
                                'package_id' => $package->id,
                                'utoken_saved' => !empty($companyUpdateData['utoken'] ?? null),
                                'utoken_source' => $utokenSource,
                                'utoken' => $companyUpdateData['utoken'] ?? null
                            ], JSON_UNESCAPED_UNICODE),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                } catch (\Exception $e) {
                    Log::error('PaytrLog Callback Update DB Hatası', ['error' => $e->getMessage()]);
                }


                // Ödeme işlemini veritabanında tutuyoruz.
                // PayTR'den gelen total_amount'u kullan (kuruş cinsinden gelir, 100'e böl)
                $amount = isset($post['total_amount']) ? ($post['total_amount'] / 100) : $package->price;

                PackagePayment::create([
                    'company_id' => $company->id,
                    'pro_package_id' => $package->pro_package_id,
                    'amount' => $amount,
                    'payment_status' => $post['status'] ?? null
                ]);


                /// Email bilgilendirme (session kullanmadan)
                $user = isset($company->user_id) ? User::find($company->user_id) : null;
                if ($user) {
                    $this->triggerEmailTemplate('odeme-onay', $user, []);
                }

                Log::info('PayTR payment processed successfully', [
                    'merchant_oid' => $post['merchant_oid'],
                    'company_id' => $company->id,
                    'package_id' => $package->id,
                ]);
            }

            ## PayTR'ye başarılı işlem bildirimi
            echo "OK";
            exit;

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi onaylayın.
            ## 2) Eğer müşterinize mesaj / SMS / e-posta gibi bilgilendirme yapacaksanız bu aşamada yapmalısınız.
            ## 3) 1. ADIM'da gönderilen payment_amount sipariş tutarı taksitli alışveriş yapılması durumunda
            ## değişebilir. Güncel tutarı $post['total_amount'] değerinden alarak muhasebe işlemlerinizde kullanabilirsiniz.


        } else { ## Ödemeye Onay Verilmedi

            Log::info('PayTR payment failed', [
                'merchant_oid' => $post['merchant_oid'],
                'failed_reason_code' => $post['failed_reason_code'] ?? null,
                'failed_reason_msg' => $post['failed_reason_msg'] ?? null,
            ]);

            ## BURADA YAPILMASI GEREKENLER
            ## 1) Siparişi iptal edin.
            ## 2) Eğer ödemenin onaylanmama sebebini kayıt edecekseniz aşağıdaki değerleri kullanabilirsiniz.
            ## $post['failed_reason_code'] - başarısız hata kodu
            ## $post['failed_reason_msg'] - başarısız hata mesajı

            // Ödeme başarısızsa paketi siliyoruz.
            PackagePurchase::where('merchant_oid', $post['merchant_oid'])->where('status', 2)->delete();

            ## PayTR'ye başarılı bildirim (işlem başarısız olsa da bildirimi aldığımızı belirtiyoruz)
            echo "OK";
            exit;
        }
    }


    /*************************** ADMİN İŞLEMLERİ ***************************/

    public function adminIndex()
    {
        $payments = PackagePayment::orderByDesc('id')->paginate(20);
        return view('admin.payment.index', compact('payments'));
    }


    /**
     * PayTR CAPI LIST ile kayıtlı kartları alır
     * 
     * @param string $email Kullanıcının email adresi
     * @param string $utoken Kullanıcının utoken'ı
     * @return array Kayıtlı kartlar listesi
     */
    private function getSavedCardsFromPayTR($email, $utoken)
    {
        if (!$email || !$utoken) {
            return [];
        }

        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';

        // PayTR CAPI LIST için hash: utoken + merchant_salt (merchant_id YOK!)
        // PayTR dokümantasyonuna göre: $hash_str = $utoken . $merchant_salt;
        $hash_str = $utoken . $merchant_salt;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        $post_vals = [
            'merchant_id' => $merchant_id,
            'utoken' => $utoken,
            'paytr_token' => $paytr_token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/capi/list");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $result = curl_exec($ch);
        $curl_error = curl_errno($ch);
        $curl_error_msg = $curl_error ? curl_error($ch) : null;
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Log kaydet
        Log::info('PayTR CAPI LIST Request', [
            'email' => $email,
            'utoken_length' => strlen($utoken),
            'curl_error' => $curl_error,
            'curl_error_msg' => $curl_error_msg,
            'http_code' => $http_code,
            'result_length' => strlen($result ?? '')
        ]);

        if ($curl_error) {
            Log::error('PayTR CAPI LIST cURL hatası', [
                'error_code' => $curl_error,
                'error_message' => $curl_error_msg,
                'email' => $email
            ]);
            return [];
        }

        if (empty($result)) {
            Log::error('PayTR CAPI LIST boş yanıt', ['email' => $email, 'http_code' => $http_code]);
            return [];
        }

        // Raw response'u sakla (log için)
        $raw_response = $result;
        $result = json_decode($result, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('PayTR CAPI LIST JSON decode hatası', [
                'json_error' => json_last_error_msg(),
                'raw_response' => substr($raw_response ?? '', 0, 500),
                'email' => $email
            ]);
            return [];
        }

        // PayTR CAPI LIST başarılı olduğunda direkt kartlar array'ini döndürür (status field'ı yok)
        // Hata durumunda: {"status": "error", "err_msg": "..."}
        // Başarılı durumda: [{"ctoken": "...", "last_4": "...", ...}, ...]

        if (isset($result['status']) && $result['status'] == 'error') {
            // Hata durumu
            Log::error('PayTR CAPI LIST başarısız', [
                'status' => $result['status'],
                'error' => $result['err_msg'] ?? $result['error'] ?? 'Bilinmeyen hata',
                'full_result' => $result
            ]);
            return [];
        } elseif (is_array($result) && !isset($result['status'])) {
            // Başarılı durum - direkt kartlar array'i döndürülüyor
            // Array'in elemanları kart bilgileri (object)
            if (!empty($result) && is_array($result) && isset($result[0]) && is_array($result[0])) {
                Log::info('PayTR CAPI LIST başarılı - kartlar bulundu', [
                    'cards_count' => count($result),
                    'first_card' => $result[0] ?? null
                ]);
                return $result;
            } else {
                Log::warning('PayTR CAPI LIST başarılı ama kart yok (boş array)', [
                    'result' => $result
                ]);
            }
        } else {
            // Beklenmeyen format
            Log::warning('PayTR CAPI LIST beklenmeyen yanıt formatı', [
                'result' => $result,
                'result_type' => gettype($result),
                'is_array' => is_array($result),
                'has_status' => isset($result['status'])
            ]);
        }

        return [];
    }

    /**
     * PayTR get-user-token API ile kullanıcının utoken'ını alır.
     * 
     * NOT: iFrame API kullanıldığında utoken callback'e dönmez (PayTR açıklamasına göre normal).
     * Kart saklama email üzerinden sağlanır, bu API ile email'den utoken alınır.
     * 
     * @param string $email Kullanıcının email adresi
     * @return string|null PayTR'den gelen utoken veya null
     */
    private function getUtokenFromCapiList($email)
    {
        Log::info('getUtokenFromCapiList: API çağrısı başlatılıyor', ['email' => $email]);

        if (!$email) {
            Log::warning('get-user-token: email boş');
            return null;
        }

        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';

        // PayTR get-user-token API için hash: merchant_id + email + merchant_salt
        $hash_str = $merchant_id . $email . $merchant_salt;
        $token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        $post_vals = [
            'merchant_id' => $merchant_id,
            'email' => $email,
            'token' => $token, // PayTR dokümantasyonuna göre 'token' parametresi
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-user-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $raw_result = curl_exec($ch);
        $curl_error = curl_errno($ch);
        $curl_error_msg = $curl_error ? curl_error($ch) : null;
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // cURL hatası kontrolü
        if ($curl_error) {
            $errorData = [
                'error_code' => $curl_error,
                'error_message' => $curl_error_msg,
                'email' => $email,
                'http_code' => $http_code
            ];

            // paytr_logs tablosuna kaydet
            try {
                DB::table('paytr_logs')->insert([
                    'type' => 'get_user_token',
                    'request_data' => json_encode($post_vals, JSON_UNESCAPED_UNICODE),
                    'response_data' => json_encode($errorData, JSON_UNESCAPED_UNICODE),
                    'merchant_oid' => null,
                    'status' => 'error',
                    'error_message' => 'CURL Hatası: ' . $curl_error_msg,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Exception $e) {
                Log::error('PaytrLog get-user-token CURL DB Hatası', ['error' => $e->getMessage()]);
            }

            Log::error('get-user-token curl hatası', $errorData);
            return null;
        }

        // Raw yanıtı logla
        Log::info('get-user-token raw yanıt', [
            'email' => $email,
            'raw_response' => $raw_result,
            'http_code' => $http_code,
            'response_length' => strlen($raw_result ?? '')
        ]);

        if (empty($raw_result)) {
            Log::warning('get-user-token: boş yanıt', [
                'email' => $email,
                'http_code' => $http_code
            ]);
            return null;
        }

        $result = json_decode($raw_result, true);

        // JSON decode hatası kontrolü
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('get-user-token JSON decode hatası', [
                'email' => $email,
                'json_error' => json_last_error_msg(),
                'raw_response' => $raw_result
            ]);
            return null;
        }

        // paytr_logs tablosuna kaydet
        try {
            $logData = [
                'email' => $email,
                'status' => $result['status'] ?? 'unknown',
                'reason' => $result['reason'] ?? ($result['err_msg'] ?? 'no reason'),
                'utoken_received' => !empty($result['utoken']),
                'has_cards' => $result['has_cards'] ?? false,
                'http_code' => $http_code,
                'full_response' => $result
            ];

            DB::table('paytr_logs')->insert([
                'type' => 'get_user_token',
                'request_data' => json_encode($post_vals, JSON_UNESCAPED_UNICODE),
                'response_data' => json_encode($logData, JSON_UNESCAPED_UNICODE),
                'merchant_oid' => null,
                'status' => ($result['status'] ?? 'unknown') === 'success' && !empty($result['utoken']) ? 'success' : 'error',
                'error_message' => ($result['status'] ?? 'unknown') === 'error' ? ($result['reason'] ?? ($result['err_msg'] ?? 'no reason')) : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('PaytrLog get-user-token DB Hatası', ['error' => $e->getMessage()]);
        }

        Log::info('get-user-token API yanıtı', [
            'email' => $email,
            'status' => $result['status'] ?? 'unknown',
            'reason' => $result['reason'] ?? ($result['err_msg'] ?? 'no reason'),
            'utoken_received' => !empty($result['utoken']),
            'has_cards' => $result['has_cards'] ?? false,
            'note' => 'iFrame API kullanılıyor: utoken callback\'de gelmez, bu API ile alınır',
            'full_response' => $result
        ]);

        // Başarılı ve utoken varsa döndür
        if (isset($result['status']) && $result['status'] === 'success' && !empty($result['utoken'])) {
            Log::info('get-user-token başarılı: utoken alındı', [
                'email' => $email,
                'utoken_length' => strlen($result['utoken']),
                'has_cards' => $result['has_cards'] ?? false
            ]);
            return $result['utoken'];
        }

        // Başarısız veya utoken yok - bu normal olabilir (kart henüz kaydedilmemiş)
        if (isset($result['status']) && $result['status'] === 'error') {
            Log::info('get-user-token: utoken bulunamadı (kart henüz kaydedilmemiş olabilir, bu normal)', [
                'email' => $email,
                'error_reason' => $result['reason'] ?? ($result['err_msg'] ?? 'unknown'),
                'has_cards' => $result['has_cards'] ?? false,
                'note' => 'İlk ödeme sonrası kart kaydedilirse, sonraki ödemelerde utoken alınabilir'
            ]);
        } else {
            Log::warning('get-user-token: beklenmeyen yanıt formatı', [
                'email' => $email,
                'response' => $result
            ]);
        }

        return null;
    }
}
