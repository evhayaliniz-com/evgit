<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageRequest;
use App\Models\PackagePurchase;
use App\Models\ProPackage;
use App\Models\ProPackageCategory;
use App\Models\PackagePayment;
use App\Models\Company;
use App\Models\Service;
use App\Models\PaytrLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    private $merchantOid;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = ProPackage::orderByDesc('id')->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(PackageRequest $request)
    {
        try {
            DB::beginTransaction();

            // Paket maddelerini json olarak formatla
            $informations = null;
            if (!empty($request->informations)) {
                $filtered = array_filter($request->informations);
                $informations = !empty($filtered) ? json_encode($filtered) : null;
            }

            // Paketi oluştur
            $package = ProPackage::create([
                'title' => $request->title,
                'description' => $request->description,
                'informations' => $informations,
                'status' => $request->status ?? 0,
            ]);

            // Tüm kategoriler için kayıt oluştur
            foreach (get_categories() as $category) {
                $categoryId = $category->id;

                ProPackageCategory::create([
                    'pro_package_id' => $package->id,
                    'category_id' => $categoryId,
                    'rights' => $request->rights[$categoryId] ?? null,
                    'monthly_price' => $request->monthly_price[$categoryId] ?? null,
                    'yearly_price' => $request->yearly_price[$categoryId] ?? null,
                    'status' => $request->category_status[$categoryId] ?? 0,

                    // ✅ Yeni eklenen alanlar
                    'eplan_preview' => $request->eplan_preview[$categoryId] ?? 0,
                    'eplan_detail' => $request->eplan_detail[$categoryId] ?? 0,
                    'eplan_monthly_download_limit' => $request->eplan_monthly_download_limit[$categoryId] ?? 0,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.packages.index')->withSuccess('İşlem tamamlandı.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.packages.index')->withError('İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $package = ProPackage::findOrFail($id);
        $packageCategories = ProPackageCategory::where('pro_package_id', $id)->get();
        return view('admin.packages.edit', compact('package', 'packageCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $package = ProPackage::findOrFail($id);

            // Paket için eklenen maddeleri json olarak tabloda tutuyoruz
            $informations = null;
            if (!empty($request->informations)) {
                $filtered = array_filter($request->informations);
                $informations = !empty($filtered) ? json_encode($filtered) : null;
            }

            // Paketi güncelliyoruz.
            $package->update([
                'title' => $request->title,
                'description' => $request->description,
                'informations' => $informations,
                'status' => $request->status ?? 0,
            ]);

            // Kategorilere göre değerleri güncelliyoruz veya oluşturuyoruz
            foreach (get_categories() as $category) {
                $categoryId = $category->id;

                ProPackageCategory::updateOrCreate(
                    ['category_id' => $categoryId, 'pro_package_id' => $id],
                    [
                        'rights' => $request->rights[$categoryId] ?? null,
                        'monthly_price' => $request->monthly_price[$categoryId] ?? null,
                        'yearly_price' => $request->yearly_price[$categoryId] ?? null,
                        'status' => $request->category_status[$categoryId] ?? 0,

                        // ✅ Yeni eklenen alanlar:
                        'eplan_preview' => $request->eplan_preview[$categoryId] ?? 0,
                        'eplan_detail' => $request->eplan_detail[$categoryId] ?? 0,
                        'eplan_monthly_download_limit' => $request->eplan_monthly_download_limit[$categoryId] ?? 0,
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.packages.index')->withSuccess('İşlem tamamlandı.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.packages.index')->withError('İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProPackage::whereId($id)->delete();
        ProPackageCategory::where('pro_package_id', $id)->delete();
        return redirect()->route('admin.packages.index')->withSuccess('İşlem tamamlandı.');
    }


    public function purchasedPackagesIndex($status = null)
    {
        if ($status) {
            if (!in_array($status, ['active', 'passive'])) abort(404);

            $status = $status == 'passive' ? 0 : 1;
            $purchasedPackages = PackagePurchase::where('status', $status)->orderByDesc('id')->paginate(20);
        } else {
            $purchasedPackages = PackagePurchase::orderByDesc('id')->paginate(20);
        }

        return view('admin.purchased_packages.index', compact('purchasedPackages'));
    }


    /************************** KULLANICI İŞLEMLERİ **************************/

    public function packagesIndex()
    {
        $packages = ProPackage::active()->get();
        return view('site.packages.index', compact('packages'));
    }

    public function packageCategoryValues(Request $request)
    {
        $package = ProPackage::active()->whereId($request->id)->first();

        if ($package) {
            // Pakete ait kategori ücretlerini çekiyoruz.
            $selectedCategory = ProPackageCategory::with('category')->where('pro_package_id', $package->id)
                ->where('category_id', auth()->user()->company->category_id)->where('status', 1)->first();
            $packageCategories = ProPackageCategory::with('category')->where('id', '!=', $selectedCategory?->id)
                ->where('pro_package_id', $package->id)->where('status', 1)->get();

            // Kullanıcının daha önce satın aldığı kategori paketlerini çekiyoruz (detaylı bilgi ile)
            $purchasedPackages = auth()->user()->company->purchasedPackages()
                ->with('package')
                ->get()
                ->map(function ($item) {
                    return [
                        'category_id' => $item->category_id,
                        'package_name' => $item->package->title ?? 'Paket',
                        'type' => $item->type === 'monthly' ? 'Aylık' : 'Yıllık'
                    ];
                });

            return response()->json([
                'selected_category' => $selectedCategory,
                'categories' => $packageCategories,
                'purchased_packages' => $purchasedPackages
            ]);
        } else {
            // Veriler yoksa boş döndürüyoruz.
            return response()->json(['selected_category' => null, 'categories' => [], 'purchased_packages' => []]);
        }
    }


    // Paket iptali
    public function cancel($id)
    {
        // Paketin durumunu kontrol ediyoruz.
        $package = PackagePurchase::active()->whereId($id)->where('company_id', auth()->user()->company->id)->firstOrFail();
        $company = auth()->user()->company;

        // Otomatik yenilemeyi kapatıyoruz (eğer aktifse)
        if ($company->auto_renew) {
            $company->update(['auto_renew' => false]);
        }

        // NOT: Paketi pasif YAPMIYORUZ çünkü kullanıcı kalan süre boyunca kullanabilmeli
        // Status = 1 olarak kalacak, sadece otomatik yenileme durdurulacak
        // Paket end_date geldiğinde otomatik olarak listelenmeyi durduracak (subscriptionsIndex'te where('end_date', '>=', now()) kontrolü var)

        // NOT: Servisleri de pasif YAPMIYORUZ çünkü kullanıcı kalan süre boyunca kullanabilmeli
        // Servisler aktif kalacak, end_date geldiğinde zaten paket aktif olmayacağı için ilan verilemeyecek

        return redirect()->back()->withSuccess('Aboneliğiniz iptal edildi. Otomatik yenileme durduruldu. Paket süreniz (' . \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') . ') dolana kadar aktif kalacaktır.');
    }

    // Aboneliklerim sayfası
    public function subscriptionsIndex()
    {
        $company = auth()->user()->company;

        // Aktif ana paketler (firmanın kendi kategorisindeki paketler)
        $activeMainPackages = PackagePurchase::where('company_id', $company->id)
            ->where('status', 1)
            ->where('category_id', $company->category_id)
            ->where('end_date', '>=', now())
            ->with(['package', 'category'])
            ->orderByDesc('created_at')
            ->get();

        // Aktif ek paketler (firmanın kendi kategorisi dışındaki paketler)
        $activeAdditionalPackages = PackagePurchase::where('company_id', $company->id)
            ->where('status', 1)
            ->where('category_id', '!=', $company->category_id)
            ->where('end_date', '>=', now())
            ->with(['package', 'category'])
            ->orderByDesc('created_at')
            ->get();

        // Geçmiş paketler (status 0 veya end_date geçmiş)
        $expiredPackages = PackagePurchase::where('company_id', $company->id)
            ->where(function ($query) {
                $query->where('status', 0)
                    ->orWhere('end_date', '<', now());
            })
            ->with(['package', 'category'])
            ->orderByDesc('end_date')
            ->get();

        // Yükseltme için mevcut paketler (mevcut paketten daha yüksek ID'li paketler)
        $currentPackageIds = $activeMainPackages->pluck('pro_package_id')->toArray();
        $availablePackages = ProPackage::active()
            ->whereNotIn('id', $currentPackageIds)
            ->orderBy('id')
            ->get();

        // Her paket için kategori bazlı fiyat bilgilerini al
        $packagePrices = [];
        foreach ($availablePackages as $pkg) {
            $packageCategory = ProPackageCategory::where('pro_package_id', $pkg->id)
                ->where('category_id', $company->category_id)
                ->where('status', 1)
                ->first();

            if ($packageCategory) {
                $packagePrices[$pkg->id] = [
                    'monthly_price' => $packageCategory->monthly_price,
                    'yearly_price' => $packageCategory->yearly_price,
                    'rights' => $packageCategory->rights,
                ];
            }
        }

        return view('site.subscriptions.index', compact(
            'activeMainPackages',
            'activeAdditionalPackages',
            'expiredPackages',
            'availablePackages',
            'packagePrices',
            'company'
        ));
    }


    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            /*
             * Firmanın aktif olarak kullandığı bir paketi varsa, sadece kendi paketinden yüksek olan paketlerin satın alınabilmesi
             * için kontrol sağlıyoruz.
             */

            // Firma bilgileri
            $company = auth()->user()->company;

            // Seçmiş olduğu paket yoksa hata mesajı döndürüyoruz.
            if (!ProPackage::active()->whereId($request->package_id)->first()) {
                DB::rollback();
                return redirect()->back()->withError('Paket bulunamadı.');
            }


            // Kullanıcının seçmiş olduğu paketleri veritabanından çekiyoruz.
            // Kullanıcının kendi kategorisini default olarak ekliyoruz.
            $selectedCategories = collect($request->categories)->add((string)auth()->user()->company->category_id);
            $selectedCategories = $selectedCategories->values()->toArray();

            $selectedPackages = ProPackageCategory::active()->where('pro_package_id', $request->package_id)
                ->whereIn('category_id', $selectedCategories)->get();


            // Paketin bilgilerini sessiona ekliyoruz.
            session(['pro_package_ids' => $selectedPackages->pluck('id')->toArray(), 'package_type' => $request->package_type]);


            // Direkt API kullanılıyor - token gerekmiyor, direkt ödeme sayfasına yönlendirilecek
            // merchant_oid oluşturuluyor (önce oluşturulmalı çünkü paket kaydında kullanılacak)
            $merchant_oid = str_replace('.', '', microtime(true)) . mt_rand(1000, 9999);
            $this->merchantOid = $merchant_oid;


            if ($selectedPackages->isNotEmpty()) {
                $totalPrice = 0;

                foreach ($selectedPackages as $selectedPackage) {
                    // Kullanım hakkı kendi paketi veya daha yüksek olan paketi id değerine göre seçiyoruz.
                    $package = PackagePurchase::active()->where('company_id', auth()->user()->company->id)
                        ->where('pro_package_id', $request->package_id)->where('category_id', $selectedPackage->category_id)->first();

                    // Paket yoksa bilgilendirme mesajı döndürüyoruz.
                    if ($package && $package->rights > $selectedPackage->rights) {
                        DB::rollback();
                        return redirect()->back()->withError('Aktif bir paketiniz olduğu sürece sadece kendi paketiniz veya
                            üstündeki paketleri satın alabilirsiniz.');
                    }

                    // Yeni paketi oluşturup id değerini firmaya atıyoruz.
                    // Ödeme işlemi başarılı olduktan sonra status değerini 1 olarak güncelleyeceğiz.
                    PackagePurchase::create([
                        'company_id' => $company->id,
                        'pro_package_id' => $selectedPackage->pro_package_id,
                        'category_id' => $selectedPackage->category_id,
                        'price' => $request->package_type == 1 ? $selectedPackage->yearly_price : $selectedPackage->monthly_price,
                        'used_rights' => 0,
                        'remaining_rights' => $selectedPackage->rights,
                        'total_rights' => $selectedPackage->rights,
                        'type' => $request->package_type == 1 ? 'yearly' : 'monthly',
                        'duration' => $request->package_type == 1 ? 365 : 30,
                        'start_date' => now(),
                        'end_date' => now()->addDays($request->package_type == 1 ? 365 : 30),
                        'merchant_oid' => $this->merchantOid,
                        'status' => 2,
                    ]);

                    $totalPrice += $request->package_type == 1 ? $selectedPackage->yearly_price : $selectedPackage->monthly_price;
                }

                // Toplam ücreti sessiona atıyoruz.
                session(['total_price' => $totalPrice]);
            } else {
                // Seçili bir paket yoksa hata mesajı döndürüyoruz.
                DB::rollback();
                return redirect()->back()->withError('En az 1 paket seçmelisiniz.');
            }


            // Paket türü aylık veya yıllık (1 veya 2) değilse geri döndürüyoruz.
            if (!in_array($request->package_type, [1, 2])) {
                DB::rollback();
                return redirect()->back();
            }

            DB::commit();

            // ÖNEMLİ: Paketlerin aktifleştirilmesi ve ödeme kaydının oluşturulması
            // PaymentController::transactions() metodunda PayTR'den başarılı ödeme 
            // bildirimi alındıktan SONRA yapılacaktır.
            // Burada sadece status=2 (beklemede) olarak paketler oluşturulur.


            // Paketin verilerini sepete ekleyip ödeme ekranına yönlendiriyoruz.
            /*
            session(['package' => ['pro_package_id' => $package->id, 'price' => $package->price, 'rights' => $package->rights,
                'type' => $package->type, 'exists' => $company->package_id ? true : false, 'company_id' => $company->id,
                'company_package' => $company->package_id ?? null, 'token' => $this->getToken()]]);
            */


            // Ödeme sayfasına yönlendiriyoruz.
            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            DB::rollback();
            //            return $e->getLine() . ' - ' . $e->getMessage();
            return redirect()->back()->withError('İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }


    private function getToken()
    {
        ## 1. ADIM için örnek kodlar ##

        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
        $merchant_id = '553263';
        $merchant_key = 'gsJN9qg9A8EhQLJ1';
        $merchant_salt = 'e4kE83W6RPyJMBy8';
        #
        ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
        //        $email = "bilgeokull@gmail.com";
        $email = auth()->user()->email;
        #
        // Paketin bilgilerini alıyoruz.
        $packages = ProPackageCategory::active()->whereIn('id', session('pro_package_ids'))->get();

        ## Tahsil edilecek tutar.
        //9.99 için 9.99 * 100 = 999 gönderilmelidir.
        $payment_amount = session('package_type') == 1 ? ($packages->sum('yearly_price') * 100) : ($packages->sum('monthly_price') * 100);
        #
        ## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
        $merchant_oid = str_replace('.', '', microtime(true)) . mt_rand(1000, 9999);
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
        $user_name = auth()->user()->company->name ?? 'Kullanıcı Adı';
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
        $user_address = auth()->user()->company->address ?? 'Adres Bilgisi Yok';
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
        $user_phone = auth()->user()->company->mobile_phone ?? '0000000000';
        #
        ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_ok_url = env('APP_URL') . "/odeme-basarili";
        #
        ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_fail_url = env('APP_URL') . "/odeme-basarisiz";
        #
        ## Müşterinin sepet/sipariş içeriği

        // Ürünleri sepete ekliyoruz.
        $user_basket = [];
        foreach ($packages as $pck) {
            $price = session('package_type') == 1 ? $pck->yearly_price : $pck->monthly_price;
            $user_basket[] = [
                $pck->package->title . ' - ' . $pck->category->name,
                number_format($price, 2, '.', ''),
                1
            ];
        }

        $user_basket = base64_encode(json_encode($user_basket));
        #
        /* ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
        $user_basket = base64_encode(json_encode(array(
            array("Örnek ürün 1", "18.00", 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
            array("Örnek ürün 2", "33.25", 2), // 2. ürün (Ürün Ad - Birim Fiyat - Adet )
            array("Örnek ürün 3", "45.42", 1)  // 3. ürün (Ürün Ad - Birim Fiyat - Adet )
        )));
        */
        ############################################################################################

        ## Kullanıcının IP adresi
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
        ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
        $user_ip = $ip;
        ##

        ## İşlem zaman aşımı süresi - dakika cinsinden
        $timeout_limit = "30";

        ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
        $debug_on = 1;

        ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
        $test_mode = 0;

        $no_installment = 1; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

        ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
        ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
        $max_installment = 0;

        $currency = "TL";

        ## Kart saklama özelliği (1 = aktif, 0 = pasif)
        $store_card = 1;

        ## ÖNCE PayTR'den utoken kontrolü yap, varsa DB'ye kaydet
        $company = auth()->user()->company;
        $utoken = $company->utoken ?? '';

        Log::info('getToken: utoken kontrolü başlatılıyor', [
            'company_id' => $company->id,
            'email' => $email,
            'db_utoken_exists' => !empty($utoken),
            'db_utoken_length' => strlen($utoken ?? '')
        ]);

        // Eğer DB'de utoken yoksa, PayTR'den kontrol et
        if (empty($utoken)) {
            Log::info('getToken: DB\'de utoken yok, PayTR\'den alınıyor');
            $utokenFromPayTR = $this->getUtokenFromPayTR($email);
            if ($utokenFromPayTR) {
                // PayTR'den gelen utoken'ı DB'ye kaydet
                $company->update(['utoken' => $utokenFromPayTR]);
                $utoken = $utokenFromPayTR;
                Log::info('utoken PayTR\'den alındı ve DB\'ye kaydedildi', [
                    'company_id' => $company->id,
                    'email' => $email,
                    'utoken_length' => strlen($utoken)
                ]);
            } else {
                Log::info('getToken: PayTR\'den utoken alınamadı (kart henüz kaydedilmemiş olabilir)');
            }
        } else {
            Log::info('getToken: DB\'de utoken mevcut, PayTR\'den kontrol edilmedi', [
                'utoken_length' => strlen($utoken)
            ]);
        }

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        // NOT: store_card hash hesaplamasına dahil EDİLMEZ!
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));
        $post_vals = array(
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => $user_basket,
            'debug_on' => $debug_on,
            'no_installment' => $no_installment,
            'max_installment' => $max_installment,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit' => $timeout_limit,
            'currency' => $currency,
            'test_mode' => $test_mode,
            'lang' => 'tr',
            'store_card' => $store_card,
            'utoken' => $utoken
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
        // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = @curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            $error = curl_error($ch);

            // Database'e kaydet (try-catch ile)
            try {
                DB::table('paytr_logs')->insert([
                    'type' => 'token_request',
                    'request_data' => json_encode($post_vals, JSON_UNESCAPED_UNICODE),
                    'response_data' => null,
                    'merchant_oid' => $merchant_oid,
                    'status' => 'error',
                    'error_message' => 'CURL Hatası: ' . $error,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } catch (\Exception $e) {
                // DB hatası olsa bile devam et
                Log::error('PaytrLog CURL DB Hatası', ['error' => $e->getMessage()]);
            }

            Log::error('PayTR Token CURL Hatası', ['error' => $error]);
            return false;
        }

        curl_close($ch);

        $result = json_decode($result, 1);

        // Database'e kaydet - TÜM VERİLER (try-catch ile)
        try {
            DB::table('paytr_logs')->insert([
                'type' => 'token_request',
                'request_data' => json_encode($post_vals, JSON_UNESCAPED_UNICODE),
                'response_data' => json_encode($result, JSON_UNESCAPED_UNICODE),
                'merchant_oid' => $merchant_oid,
                'status' => isset($result['status']) && $result['status'] == 'success' ? 'success' : 'error',
                'error_message' => isset($result['reason']) ? $result['reason'] : (isset($result['error']) ? json_encode($result['error']) : 'Bilinmeyen hata'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // DB hatası olsa bile devam et - HATAYI DA LOGLAYALIM
            Log::error('PaytrLog DB Hatası', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }

        if (isset($result['status']) && $result['status'] == 'success') {
            $this->merchantOid = $merchant_oid;
            return $result['token'];
        } else {
            // Hata durumunda log at ve FALSE döndür (hata mesajını değil!)
            Log::error('PayTR Token Hatası', [
                'response' => $result,
                'merchant_id' => $merchant_id,
                'email' => $email,
                'payment_amount' => $payment_amount,
                'user_basket' => $user_basket
            ]);
            return false; // ÖNEMLİ: false döndür, hata mesajı döndürme!
        }
    }

    /**
     * PayTR get-user-token API ile kullanıcının utoken'ını alır.
     * Ödeme isteği atmadan önce PayTR'den utoken kontrolü yapılır.
     * 
     * @param string $email Kullanıcının email adresi
     * @return string|null PayTR'den gelen utoken veya null
     */
    private function getUtokenFromPayTR($email)
    {
        Log::info('getUtokenFromPayTR: API çağrısı başlatılıyor', ['email' => $email]);

        if (!$email) {
            Log::warning('getUtokenFromPayTR: email boş');
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
            'token' => $token,
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
            Log::error('getUtokenFromPayTR curl hatası', [
                'error_code' => $curl_error,
                'error_message' => $curl_error_msg,
                'email' => $email,
                'http_code' => $http_code
            ]);
            return null;
        }

        if (empty($raw_result)) {
            Log::warning('getUtokenFromPayTR: boş yanıt', [
                'email' => $email,
                'http_code' => $http_code
            ]);
            return null;
        }

        $result = json_decode($raw_result, true);

        // JSON decode hatası kontrolü
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('getUtokenFromPayTR JSON decode hatası', [
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
                'utoken_received' => !empty($result['utoken']),
                'has_cards' => $result['has_cards'] ?? false,
                'http_code' => $http_code,
                'full_response' => $result,
                'note' => 'Ödeme öncesi utoken kontrolü (PackageController)'
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
            Log::error('PaytrLog getUtokenFromPayTR DB Hatası', ['error' => $e->getMessage()]);
        }

        Log::info('getUtokenFromPayTR yanıtı', [
            'email' => $email,
            'status' => $result['status'] ?? 'unknown',
            'utoken_received' => !empty($result['utoken']),
            'response' => $result
        ]);

        // Başarılı ve utoken varsa döndür
        if (isset($result['status']) && $result['status'] === 'success' && !empty($result['utoken'])) {
            return $result['utoken'];
        }

        return null;
    }
}
