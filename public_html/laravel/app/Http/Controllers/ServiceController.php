<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Category;
use App\Models\District;
use App\Models\PackagePurchase;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use App\Models\ServiceQuestion;
use App\Models\Report;
use App\Models\View;
use App\Models\ServiceSaved;
use App\Models\OldPrice;
use App\Models\CategoryParameter;
use App\Models\ServiceParameterValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
//use Image;
use Intervention\Image\Laravel\Facades\Image;
use App\Mail\AdminNewServiceNotification;
use App\Traits\AdminNotificationTrait;
use App\Traits\NotificationTrait;
use App\Traits\EmailTemplateTrait;
use App\Helpers\CacheHelper;



class ServiceController extends Controller
{
    use NotificationTrait, EmailTemplateTrait, AdminNotificationTrait;

    // Kullanıcılara listeleme
    public function list(Request $request)
    {
        $services = Service::query();

        // Filtreleme işlemleri
        if ($request->category) {
            $services = $services->where('category_id', $request->category);
        }

        if ($request->sub_category) {
            $subCategories = is_array($request->sub_category) ? $request->sub_category : explode(',', (string)$request->sub_category);
            $subCategories = array_values(array_filter($subCategories));
            if (!empty($subCategories)) {
                $services = $services->whereIn('sub_category_id', $subCategories);
            }
        }

        if ($request->province) {
            $services = $services->where('province_id', $request->province);
        }

        if ($request->district) {
            $districts = is_array($request->district) ? $request->district : explode(',', (string)$request->district);
            $districts = array_values(array_filter($districts));
            if (!empty($districts)) {
                $services = $services->whereIn('district_id', $districts);
            }
        }

        if ($request->min_price) {
            $minPrice = str_replace(['.', ' ', ','], '', $request->min_price);
            if (is_numeric($minPrice)) {
                $services = $services->where('price', '>=', $minPrice);
            }
        }

        if ($request->max_price) {
            $maxPrice = str_replace(['.', ' ', ','], '', $request->max_price);
            if (is_numeric($maxPrice)) {
                $services = $services->where('price', '<=', $maxPrice);
            }
        }

        if ($request->min_sqm) {
            $services = $services->where('sqm', '>=', $request->min_sqm);
        }

        if ($request->max_sqm) {
            $services = $services->where('sqm', '<=', $request->max_sqm);
        }

        if ($request->q) {
            $services = $services->where('title', 'LIKE', '%' . $request->q . '%');
        }

        // Dinamik parametre filtreleri
        if ($request->has('parameters') && is_array($request->parameters)) {
            foreach ($request->parameters as $paramId => $value) {
                if (!empty($value)) {
                    $services = $services->whereHas('parameterValues', function ($query) use ($paramId, $value) {
                        $query->where('category_parameter_id', $paramId)
                            ->where('value', 'LIKE', '%' . $value . '%');
                    });
                }
            }
        }

        // Akıllı sıralama işlemi
        if ($request->order_by) {
            switch ($request->order_by) {
                case 'price_asc':
                    $services = $services->orderBy('price', 'ASC');
                    break;

                case 'price_desc':
                    $services = $services->orderBy('price', 'DESC');
                    break;

                case 'sqm_asc':
                    $services = $services->orderBy('sqm', 'ASC');
                    break;

                case 'sqm_desc':
                    $services = $services->orderBy('sqm', 'DESC');
                    break;
            }
        }

        $serviceCount = $services->active()->confirmed()->count();
        $services = $services->active()->confirmed()
            ->with(['photos', 'category', 'subCategory', 'province', 'district', 'company', 'oldPrices'])
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        // Seçili kategorinin parametrelerini getir
        $categoryParameters = [];
        if ($request->category) {
            $categoryParameters = CategoryParameter::where('category_id', $request->category)
                ->active()
                ->ordered()
                ->get();
        }

        return view('site.services.index', compact('services', 'serviceCount', 'categoryParameters'));
    }


    // Firmanın hizmet istatistiklerini hesapla
    private function getCompanyServiceStats(int $companyId): array
    {
        $baseQuery = Service::where('company_id', $companyId);

        return [
            'total' => (clone $baseQuery)->count(),
            'published' => (clone $baseQuery)->where('status', 1)->where('is_confirmed', 1)->count(),
            'active' => (clone $baseQuery)->where('status', 1)->count(),
            'pending' => (clone $baseQuery)->where('is_confirmed', 0)->count(),
            'passive' => (clone $baseQuery)->where('status', 0)->count(),
        ];
    }

    // Firmanın kendi servislerini profilde listeleme
    public function index(Request $request)
    {
        $companyId = auth()->user()->company->id;
        $query = Service::where('company_id', $companyId);

        // Arama işlemi
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', $searchTerm);
            });
        }

        // Durum filtreleme
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('status', 1);
            } elseif ($request->status === 'pasif') {
                $query->where('status', 0);
            } elseif ($request->status === 'onay_bekleyen') {
                $query->where('is_confirmed', 0);
            } elseif ($request->status === 'yayinda') {
                $query->where('status', 1)->where('is_confirmed', 1);
            }
        }

        // Sayfalama limiti
        $perPage = $request->per_page && in_array((int) $request->per_page, [10, 20, 50, 100]) ? (int) $request->per_page : 20;

        // Sıralama işlemi
        $sortBy = $request->sort_by;
        $sortOrder = $request->sort_order && in_array($request->sort_order, ['asc', 'desc']) ? $request->sort_order : 'desc';

        // Görüntülenme ve kaydetme sayılarını dahil et
        $services = $query->withCount([
            'views as view_count' => function ($query) {
                $query->where('type', 'service');
            },
            'savedServices as saved_count'
        ])
            ->with(['category', 'subCategory', 'province', 'district', 'photos']);

        // Sıralama uygula
        if ($sortBy && in_array($sortBy, ['id', 'price', 'view_count', 'saved_count', 'created_at'])) {
            $services = $services->orderBy($sortBy, $sortOrder);
        } else {
            $services = $services->orderByDesc('id');
        }

        $services = $services->paginate($perPage)
            ->withQueryString();

        $serviceStats = $this->getCompanyServiceStats($companyId);

        return view('site.services.profile-index', compact('services', 'serviceStats'));
    }

    public function updatePrice(Request $request, $id)
    {
        try {
            $request->validate([
                'price' => 'required|numeric|min:1'
            ]);

            $service = Service::whereId($id)->where('company_id', auth()->user()->company->id)->firstOrFail();

            // Eski fiyatı kaydet
            OldPrice::create([
                'service_id' => $service->id,
                'price' => $service->price
            ]);

            $service->price = $request->price;
            $service->save();

            // Cache'i temizle
            CacheHelper::clearServiceCache();

            return response()->json([
                'success' => true,
                'message' => 'Fiyat başarıyla güncellendi.',
                'new_price' => number_format($service->price, 0, ',', '.'),
                'raw_price' => intval($service->price)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $companyId = auth()->user()->company->id;
        $query = Service::where('company_id', $companyId);

        // Arama işlemi
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', $searchTerm);
            });
        }

        // Durum filtreleme
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('status', 1);
            } elseif ($request->status === 'pasif') {
                $query->where('status', 0);
            } elseif ($request->status === 'onay_bekleyen') {
                $query->where('is_confirmed', 0);
            } elseif ($request->status === 'yayinda') {
                $query->where('status', 1)->where('is_confirmed', 1);
            }
        }

        // Sayfalama limiti
        $perPage = $request->per_page && in_array((int) $request->per_page, [10, 20, 50, 100]) ? (int) $request->per_page : 20;

        // Sıralama işlemi
        $sortBy = $request->sort_by;
        $sortOrder = $request->sort_order && in_array($request->sort_order, ['asc', 'desc']) ? $request->sort_order : 'desc';

        // Görüntülenme ve kaydetme sayılarını dahil et
        $services = $query->withCount([
            'views as view_count' => function ($query) {
                $query->where('type', 'service');
            },
            'savedServices as saved_count'
        ])
            ->with(['category', 'subCategory', 'province', 'district', 'photos']);

        // Sıralama uygula
        if ($sortBy && in_array($sortBy, ['id', 'price', 'view_count', 'saved_count', 'created_at'])) {
            $services = $services->orderBy($sortBy, $sortOrder);
        } else {
            $services = $services->orderByDesc('id');
        }

        $services = $services->paginate($perPage);
        $services->withPath(route('company.services.index'));

        $serviceStats = $this->getCompanyServiceStats($companyId);

        return response()->json([
            'success' => true,
            'html' => view('site.services.partials.services-table', compact('services'))->render(),
            'pagination' => $services->links()->render(),
            'total' => $services->total(),
            'stats' => $serviceStats
        ]);
    }

    // Kayıt edilen servisleri listeliyoruz.
    public function savedServices(Request $request)
    {
        $saved = ServiceSaved::where('user_id', auth()->user()->id)->get()->pluck('service_id')->toArray();
        $services = Service::active()->confirmed()->whereIn('id', $saved)->orderByDesc('id')->paginate(12);

        return view('site.services.saved', compact('services'));
    }

    public function savedServicesDestroy($id)
    {
        ServiceSaved::where('service_id', $id)->where('user_id', auth()->user()->id)->delete();
        return redirect()->back()->withSuccess('Kayıtlı servislerden kaldırıldı.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (auth()->user()->company->purchasedPackages->isEmpty()) {
            return redirect()->route('company.packages.index')->withError('Hizmet oluşturabilmek için paket satın almanız gerekmektedir.');
        }

        return view('site.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        try {

            DB::beginTransaction();

            // Satın alınan paketi kategori id değerine göre kontrol ediyoruz.
            $companyPackage = auth()->user()->company->purchasedPackages->where('category_id', $request->category_id)->where('status', 1)->where('remaining_rights', '>', 0)->first();

            // Paket yoksa satın alma ekranına döndürüyoruz.
            if (!$companyPackage || auth()->user()->company->purchasedPackages->isEmpty()) {
                return redirect()->route('company.packages.index')->withError('Hizmet oluşturabilmek için paket satın almanız gerekmektedir.');
            }

            // Paketin kullanım hakkı dolduysa bildirim mesajı döndürüyoruz.
            if ($companyPackage->remaining_rights == 0) {
                DB::rollBack();
                return redirect()->route('company.services.create')->withError('Paketin kullanım hakkı bulunmuyor.
                    Hizmet oluşturabilmek için yeni bir pro üyelik satın almalısınız.');
            }


            // İle ait ilçe var mı kontrolünü yapıyoruz.
            if (!District::whereId($request->district_id)->where('city_id', $request->province_id)->first()) {
                DB::rollBack();
                return redirect()->route('company.services.create')->withError('İlçe bulunamadı.');
            }


            // Alt kategorinin varlığını kontrol ediyoruz.
            $subCategoryExists = Category::whereId($request->sub_category_id)->where('parent_id', $request->category_id)
                ->where('status', 1)->first();

            if (!$subCategoryExists) {
                return redirect()->back()->withError('Alt kategori bulunamadı.');
            }

            // Servisi oluşturuyoruz.
            $service = Service::create([
                //                'cover_photo' => $fileName,
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,

                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sqm' => 0, // Geçici default değer
                'rooms' => '', // Geçici default değer
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'company_id' => auth()->user()->company->id,
                'video_link' => $request->video_link,
            ]);

            // Slug değerini güncelliyoruz
            Service::whereId($service->id)->where('company_id', auth()->user()->company->id)
                ->update(['slug' => str()->slug($request->title) . '-' . $service->id, 'created_at' => now()]);


            // Ücreti eski ücretler tablosuna ekliyoruz.
            OldPrice::create(['service_id' => $service->id, 'price' => $request->price]);


            // Diğer dosyalar dropzone ile yüklendiği için sadece isimlerini düzenleyip veritabanına ekliyoruz.
            $photos = [];
            \Log::info('Service store - uploaded_files received', [
                'uploaded_files' => $request->uploaded_files,
                'service_id' => $service->id,
                'user_id' => auth()->id()
            ]);

            if (!empty($request->uploaded_files)) {
                foreach (explode(',', $request->uploaded_files) as $photo) {
                    if (!empty(trim($photo))) {
                        $photos[] = ['path' => trim($photo), 'service_id' => $service->id];
                    }
                }
            }

            // Paketin kullanım hakkını düzenliyoruz.
            $companyPackage->used_rights += 1;
            $companyPackage->remaining_rights -= 1;
            $companyPackage->save();

            \Log::info('Service store - photos to be inserted', [
                'photos' => $photos,
                'photos_count' => count($photos),
                'service_id' => $service->id
            ]);

            if (!empty($photos)) {
                ServiceImage::insert($photos);
                \Log::info('Service store - photos inserted successfully', [
                    'service_id' => $service->id,
                    'photos_count' => count($photos)
                ]);
            } else {
                \Log::warning('Service store - no photos to insert', [
                    'service_id' => $service->id,
                    'uploaded_files' => $request->uploaded_files
                ]);
            }

            // Kategori parametrelerini kaydet (eğer tablo varsa)
            if ($request->has('parameters') && is_array($request->parameters)) {
                // Tabloların varlığını kontrol et
                if (\Schema::hasTable('service_parameter_values') && \Schema::hasTable('category_parameters')) {
                    foreach ($request->parameters as $parameterId => $value) {
                        if (!empty($value)) {
                            try {
                                ServiceParameterValue::create([
                                    'service_id' => $service->id,
                                    'category_parameter_id' => $parameterId,
                                    'value' => $value
                                ]);
                            } catch (\Exception $paramError) {
                                \Log::error('Parameter save error: ' . $paramError->getMessage());
                                // Parametre kaydında hata varsa devam et, servisi kaydet
                            }
                        }
                    }
                } else {
                    \Log::warning('Parameter tables not found, skipping parameter save');
                }
            }

            DB::commit();

            $user = auth()->user();
            $service->loadMissing('company');

            $this->triggerEmailTemplate('new-service-created', $user, []);
            $this->notifyAdmins(new AdminNewServiceNotification($service, $user));

            $serviceTitle = (string) Str::of($service->title ?? 'Yeni hizmet')
                ->squish()
                ->limit(80);

            $this->createAdminNotifications(
                'Yeni hizmet eklendi: ' . $serviceTitle,
                route('admin.services.index'),
                $user->id
            );

            // Cache'i temizle
            CacheHelper::clearServiceCache();

            return redirect()->route('company.services.index')->withSuccess('Servis oluşturuldu.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Service create error: ' . $e->getMessage() . ' Line: ' . $e->getLine());
            return redirect()->route('company.services.create')->withError('İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Servisi bul - sadece confirmed olanları göster VEYA kendi servisiyse göster
        $service = Service::with('parameterValues.categoryParameter')->active()->where('slug', $slug)
            ->where(function ($query) {
                $query->where('is_confirmed', 1);
                // Eğer giriş yapmışsa ve firma sahibiyse kendi onaylanmamış servisini de görebilsin
                if (auth()->check() && auth()->user()->user_type === 'company' && auth()->user()->company) {
                    $query->orWhere('company_id', auth()->user()->company->id);
                }
            })
            ->firstOrFail();

        $similarServices = Service::active()->confirmed()->where('id', '!=', $service->id)->where('sub_category_id', $service->sub_category_id)
            ->orderByDesc('id')->limit(10)->get();

        $questions = ServiceQuestion::where('service_id', $service->id)->orderByDesc('id')->paginate(6);

        // Giriş yapan kullanıcının ip adresinden görüntülenme almamışsa servis görüntülenme değeri için ip adresini
        // veritabanına kayıt ediyoruz.
        View::firstOrCreate(['ip' => get_user_ip_address(), 'to_id' => $service->id, 'type' => 'service']);
        return view('site.services.show', compact('service', 'similarServices', 'questions'));
    }

    public function question($slug, Request $request)
    {
        $request->validate(['question' => ['required', 'string', 'max:2000']]);

        $service = Service::active()->where('slug', $slug)->firstOrFail();

        // Soruyu gönderen kişi servisin sahibi değilse soruyu oluşturuyoruz.
        if (
            auth()->user()->user_type == 'company' && auth()->user()->company->id != $service->company_id
            || auth()->user()->user_type == 'user'
        ) {
            ServiceQuestion::create(['question' => $request->question, 'user_id' => auth()->user()->id, 'service_id' => $service->id]);

            return redirect()->back()->withSuccess('Sorunuz gönderildi.');
        } else {
            return redirect()->back();
        }
    }


    public function answer($slug, Request $request)
    {
        $request->validate([
            'answer' => ['required', 'string', 'max:5000'],
            'question' => ['required']
        ]);

        try {
            $service = Service::active()->where('slug', $slug)->firstOrFail();

            // Şifreli olarak gönderilen soru id değerini decrypt ediyoruz ve sorunun varlığını kontrol ediyoruz.
            $question = Crypt::decryptString($request->question);
            $question = ServiceQuestion::whereId($question)->where('service_id', $service->id)->firstOrFail();

            ServiceQuestion::whereId($question->id)->where('service_id', $service->id)
                ->update(['answer' => $request->answer, 'company_id' => auth()->user()->company->id]);

            return redirect()->back()->withSuccess('Soru cevaplandı.');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Soru bulunamadı.');
        }
    }


    public function questionDestroy($slug, $id)
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();

        if ($service->company_id == auth()->user()?->company?->id) {
            // Servisin sahibiyse soruyu burada sildiriyoruz.
            ServiceQuestion::whereId($id)->delete();
        } else {
            // Sorunun sahibiyse soruyu burada sildiriyoruz.
            ServiceQuestion::whereId($id)->where('user_id', auth()->user()->id)->delete();
        }

        return redirect()->back()->withSuccess('Soru silindi.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::with('parameterValues')->whereId($id)->where('company_id', auth()->user()->company->id)->firstOrFail();
        $package = PackagePurchase::where('company_id', auth()->user()->company->id)
            ->where('category_id', $service->category_id)->where('status', 1)->first();

        $remainingRightMsg = $package ? $package->category->name . ' kategorisinde (' . $package->remaining_rights
            . '/' . $package->total_rights . ') hakkınız bulunmaktadır.' : null;

        return view('site.services.edit', compact('service', 'remainingRightMsg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            // Satın alınan paketi kategori id değerine göre kontrol ediyoruz.
            $companyPackage = auth()->user()->company->purchasedPackages->where('category_id', $request->category_id)->where('status', 1)->first();

            // Paket yoksa satın alma ekranına döndürüyoruz.
            if (!$companyPackage) {
                return redirect()->route('company.packages.index')->withError('Seçmiş olduğunuz kategoride hizmet oluşturabilmek
                    için seçili kategoriye ait paket satın almalısınız.');
            }


            $request->validate(['cover_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp']]);

            // Servisin varlığını kontrol ediyoruz.
            $serviceExists = Service::whereId($id)->where('company_id', auth()->user()->company->id)->firstOrFail();

            // İle ait ilçe var mı kontrolünü yapıyoruz.
            if (!District::whereId($request->district_id)->where('city_id', $request->province_id)->first()) {
                DB::rollBack();
                return redirect()->route('company.services.edit', $id)->withError('İlçe bulunamadı.');
            }


            // Alt kategorinin varlığını kontrol ediyoruz.
            $subCategoryExists = Category::whereId($request->sub_category_id)->where('parent_id', $request->category_id)
                ->where('status', 1)->first();

            if (!$subCategoryExists) {
                return redirect()->back()->withError('Alt kategori bulunamadı.');
            }


            // Servisi güncelliyoruz.
            $service = Service::whereId($id)->where('company_id', auth()->user()->company->id)->update([
                'title' => $request->title,
                'slug' => str()->slug($request->title) . '-' . $serviceExists->id,
                'description' => $request->description,
                'price' => $request->price,

                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sqm' => 0, // Geçici default değer
                'rooms' => '', // Geçici default değer
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'company_id' => auth()->user()->company->id,
                'video_link' => $request->video_link,
                'status' => $request->status
            ]);

            // Ücreti eski ücretler tablosuna ekliyoruz.
            OldPrice::create(['service_id' => $id, 'price' => $request->price]);

            // Kapak fotoğrafı yüklendiyse güncelliyoruz.
            //            if ($request->hasFile('cover_photo')) {
            ////                $imagePath = $request->file('cover_photo')->store('services', 'public');
            ////                $fileName = $imagePath;
            //
            //                $file = $request->file('cover_photo');
            //                $fileName = time() . '_' . $file->getClientOriginalName();
            //                $file->move('site/images/services', $fileName);
            //                $fileName = 'site/images/services/' . $fileName;
            //
            //                Service::whereId($id)->where('company_id', auth()->user()->company->id)->update(['cover_photo' => $fileName]);
            //            }

            // Fotoğraf işleme - Yeni ve eski fotoğrafları birleştir
            $photos = [];

            // Yeni yüklenen fotoğraflar
            if ($request->uploaded_files) {
                foreach (explode(',', $request->uploaded_files) as $photo) {
                    if ($photo) {
                        $photos[] = ['path' => $photo, 'service_id' => $id];
                    }
                }
            }

            // Eski fotoğraflar (silinmemiş olanlar)
            if ($request->old_uploaded_files) {
                foreach (explode(',', $request->old_uploaded_files) as $photo2) {
                    if ($photo2) {
                        $photos[] = ['path' => $photo2, 'service_id' => $id];
                    }
                }
            }

            // Mevcut fotoğrafları sil ve yenilerini ekle
            ServiceImage::where('service_id', $id)->delete();
            if (!empty($photos)) {
                ServiceImage::insert($photos);
            }

            // Kategori parametrelerini güncelle (eğer tablo varsa)
            if ($request->has('parameters') && is_array($request->parameters)) {
                // Tabloların varlığını kontrol et
                if (\Schema::hasTable('service_parameter_values') && \Schema::hasTable('category_parameters')) {
                    // Eski parametreleri sil
                    ServiceParameterValue::where('service_id', $id)->delete();

                    // Yeni parametreleri ekle
                    foreach ($request->parameters as $parameterId => $value) {
                        if (!empty($value)) {
                            try {
                                ServiceParameterValue::create([
                                    'service_id' => $id,
                                    'category_parameter_id' => $parameterId,
                                    'value' => $value
                                ]);
                            } catch (\Exception $paramError) {
                                \Log::error('Parameter update error: ' . $paramError->getMessage());
                                // Parametre kaydında hata varsa devam et, servisi güncelle
                            }
                        }
                    }
                } else {
                    \Log::warning('Parameter tables not found, skipping parameter update');
                }
            }

            DB::commit();

            // Cache'i temizle
            CacheHelper::clearServiceCache();

            return redirect()->route('company.services.index')->withSuccess('Servis güncellendi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('company.services.edit', $id)->withError('İşlem sırasında bir hata oluştu.
            Lütfen tekrar deneyin.');
        }
    }


    public function getRights($id)
    {
        // Kategoriye göre paketin bilgilerini alıyoruz.
        $package = PackagePurchase::where('company_id', auth()->user()->company->id)->where('category_id', $id)->where('status', 1)->first();

        if ($package) {
            // Değerleri gönderiyoruz.
            return response()->json([
                'category_name' => $package->category->name,
                'remaining_right' => $package->remaining_rights,
                'total_right' => $package->total_rights
            ]);
        } else {
            // Pakete ait veriler yoksa kategori adını boş gönderip hata çıkmasını engelliyoruz.
            return response()->json(['category_name' => null]);
        }
    }

    // Servisi profile kayıt ediyoruz.
    public function save($slug)
    {
        // Servisin varlığını kontrol ediyoruz - sadece confirmed olanları kaydet edilebilir
        $service = Service::active()->confirmed()->where('slug', $slug)->firstOrFail();

        // Kayıt edilmemişse kaydediyoruz, kayıtlıysa siliyoruz.
        $savedExists = ServiceSaved::where('user_id', auth()->user()->id)->where('service_id', $service->id)->first();
        if (!$savedExists) {
            ServiceSaved::create(['user_id' => auth()->user()->id, 'service_id' => $service->id]);

            $this->notification('service-save', $service->company->user_id, ['title' => $service->title, 'slug' => $service->slug]);

            // Mail gönder
            $this->triggerEmailTemplate('service-save', $service->company->user, [
                'service_title' => $service->title,
                'service_link' => route('services.show', $service->slug),
                'saver_name' => auth_info()->name,
            ]);

            return redirect()->back()->withSuccess('Servis kayıt edildi.');
        } else {
            ServiceSaved::where('user_id', auth()->user()->id)->where('service_id', $service->id)->delete();
            return redirect()->back()->withSuccess('Kayıtlı servislerden kaldırıldı.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $companyId = auth()->user()->company->id;
        Service::whereId($id)->where('company_id', $companyId)->delete();

        // Cache'i temizle
        CacheHelper::clearServiceCache();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Hizmet başarıyla silindi.',
                'stats' => $this->getCompanyServiceStats($companyId)
            ]);
        }

        return redirect()->route('company.services.index')->withSuccess('İşlem tamamlandı.');
    }


    // Sikayet Oluşturma
    public function report($slug, Request $request)
    {
        // Bir kullanıcı servis hakkında aktif olarak sadece 1 adet şikayet oluşturabilir.
        // Aktif olan şikayeti var mı kontrol ediyoruz. Yoksa oluşturuyoruz, varsa bilgilendirme mesajını döndürüyoruz.
        // status değerleri: 0 - aktif, 1 - çözümlenmiş

        $request->validate(['message' => ['required', 'string', 'max:5000']]);

        // Servisin varlığını kontrol ediyoruz.
        $service = Service::active()->where('slug', $slug)->firstOrFail();
        // Aktif olan bir şikayet var mı kontrol ediyoruz.
        $reportExists = Report::where('user_id', auth()->user()->id)->where('to_id', $service->id)->where('type', 'service')
            ->where('status', 0)->first();

        if (!$reportExists) {
            // Aktif şikayet yoksa oluşturuyoruz.
            Report::create([
                'message' => $request->message,
                'user_id' => auth()->user()->id,
                'to_id' => $service->id,
                'type' => 'service',
                'status' => 0
            ]);

            return redirect()->back()->withSuccess('Şikayetiniz tarafımıza ulaşmıştır.');
        } else {
            // Aktif şikayet varsa bilgilendirme mesajı döndürüyoruz.
            return redirect()->back()->withError('Hizmet üzerinde aktif olarak iletmiş olduğunuz bir şikayet konusu olduğu
            için yeni bir şikayet gönderilemiyor.');
        }
    }

    public function imageUpload(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // İzin verilen dosya türleri
                $allowedExtensions = ['jpeg', 'jpg', 'png', 'webp'];
                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, $allowedExtensions)) {
                    return response()->json(['error' => 'Sadece JPEG, JPG, PNG ve WEBP yükleyebilirsiniz!'], 400);
                }

                // Dosya adını oluştur - WebP formatına çevireceğimiz için uzantıyı webp yap
                $fileName = time() . '_' . uniqid() . '.webp';

                // Doğru klasör yolu - projenin root'undaki site klasörü
                $uploadDir = base_path('../site/images/services');

                \Log::info('Image upload - checking directory', [
                    'uploadDir' => $uploadDir,
                    'exists' => file_exists($uploadDir),
                    'writable' => is_writable(dirname($uploadDir)),
                    'parent_exists' => file_exists(dirname($uploadDir))
                ]);

                if (!file_exists($uploadDir)) {
                    $created = mkdir($uploadDir, 0755, true);
                    \Log::info('Image upload - directory created', [
                        'uploadDir' => $uploadDir,
                        'created' => $created,
                        'final_exists' => file_exists($uploadDir)
                    ]);
                }

                $image = Image::read($file->getPathname());

                // Watermark ekle
                try {
                    $image->text('www.' . parse_url(env('APP_URL'), PHP_URL_HOST), $image->width() / 2, $image->height() / 2, function ($font) {
                        $fontPath = public_path('assets/site/fonts/Roboto-Bold.ttf');
                        if (file_exists($fontPath)) {
                            $font->file($fontPath);
                        }
                        $font->size(24);
                        $font->color('rgba(255, 255, 255, 0.5)');
                        $font->align('center');
                        $font->valign('middle');
                        $font->angle(-25);
                    });
                } catch (\Exception $e) {
                    // Watermark hatası durumunda devam et
                    Log::warning('Watermark eklenirken hata: ' . $e->getMessage());
                }

                $fullPath = $uploadDir . '/' . $fileName;

                try {
                    $image->toWebp(70)->save($fullPath);

                    \Log::info('Image upload - file saved', [
                        'fullPath' => $fullPath,
                        'exists_after_save' => file_exists($fullPath),
                        'file_size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                        'permissions' => file_exists($fullPath) ? substr(sprintf('%o', fileperms($fullPath)), -4) : 'N/A'
                    ]);
                } catch (\Exception $saveError) {
                    \Log::error('Image upload - save failed', [
                        'fullPath' => $fullPath,
                        'error' => $saveError->getMessage(),
                        'uploadDir_writable' => is_writable($uploadDir)
                    ]);
                    throw $saveError;
                }

                $imagePath = 'site/images/services/' . $fileName;

                \Log::info('Service image uploaded successfully', [
                    'fileName' => $fileName,
                    'imagePath' => $imagePath,
                    'user_id' => auth()->id()
                ]);

                return response()->json([
                    "success" => true,
                    "fileName" => $imagePath,
                    "url" => $imagePath,
                    "debug" => [
                        "fullPath" => $fullPath,
                        "fileExists" => file_exists($fullPath),
                        "fileSize" => file_exists($fullPath) ? filesize($fullPath) : 0,
                        "uploadDir" => $uploadDir,
                        "uploadDirExists" => file_exists($uploadDir),
                        "uploadDirWritable" => is_writable($uploadDir)
                    ]
                ]);
            }

            return response()->json(['error' => 'Dosya yüklenemedi!'], 400);
        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            return response()->json(['error' => 'Dosya işlenirken hata oluştu: ' . $e->getMessage()], 500);
        }
    }


    public function imageDelete(Request $request)
    {
        $fileName = $request->fileName;
        $fullPath = public_path('assets/frontend/img/adverts/' . $fileName);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
            return response()->json(['success' => $request->fileName, 'message' => 'Dosya silindi!']);
        }

        return response()->json(['error' => 'Dosya bulunamadı!'], 404);
    }


    public function status(Request $request, $id)
    {
        $companyId = auth()->user()->company->id;
        $services = Service::whereId($id)->where('company_id', $companyId)->firstOrFail();

        $services->status = $services->status ? 0 : 1;
        $services->save();

        // Cache'i temizle
        CacheHelper::clearServiceCache();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'new_status' => (int) $services->status,
                'is_confirmed' => (int) $services->is_confirmed,
                'message' => $services->status ? 'Hizmet aktif edildi.' : 'Hizmet pasife alındı.',
                'stats' => $this->getCompanyServiceStats($companyId)
            ]);
        }

        return redirect()->back()->withSuccess('İşlem Tamamlandı.');
    }


    /**************************** ADMİN İŞLEMLERİ ****************************/
    public function adminIndex(Request $request, $status = null)
    {
        $services = Service::query();

        // Servis adına göre arama yapıyoruz.
        if ($request->service_name) {
            $services = $services->where('title', 'LIKE', '%' . $request->service_name . '%');
        }

        // Firma adına göre arama yapıyoruz.
        if ($request->company_name) {
            $services = $services->whereHas('company', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->company_name . '%');
            });
        }

        // Oluşturulma tarihine göre arama yapıyoruz.
        if ($request->start_date) {
            $services = $services->where('created_at', '>=', Carbon::parse($request->start_date));
        }

        // Oluşturulma tarihine göre arama yapıyoruz.
        if ($request->end_date) {
            $services = $services->where('created_at', '<=', Carbon::parse($request->end_date));
        }

        // Alt kategori değerine göre arama yapıyoruz.
        if (request()->sub_category) {
            $services = $services->where('sub_category_id', request()->sub_category);
        }

        // Durum değeri varsa denk gelen verileri çekiyoruz, yoksa tüm verileri çekiyoruz
        if ($status) {
            $status = $status == 'passive' ? 0 : 1;
            $services = $services->where('status', $status);
        }

        $serviceCount = $services->count();
        $services = $services->orderByDesc('id')->paginate(20)->withQueryString();
        $subCategories = Category::whereNotNull('parent_id')->where('status', 1)->get();

        return view('admin.services.index', compact('services', 'serviceCount', 'subCategories'));
    }


    public function adminEdit(string $id)
    {
        $service = Service::with('parameterValues')->whereId($id)->firstOrFail();
        return view('admin.services.edit', compact('service'));
    }

    public function adminUpdate(ServiceRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            // Servisin varlığını kontrol ediyoruz.
            $serviceExists = Service::findOrFail($id);

            // İle ait ilçe var mı kontrolünü yapıyoruz.
            if (!District::whereId($request->district_id)->where('city_id', $request->province_id)->first()) {
                DB::rollBack();
                return redirect()->route('admin.services.edit', $id)->withError('İlçe bulunamadı.');
            }


            // Alt kategorinin varlığını kontrol ediyoruz.
            $subCategoryExists = Category::whereId($request->sub_category_id)->where('parent_id', $request->category_id)
                ->where('status', 1)->first();

            if (!$subCategoryExists) {
                return redirect()->back()->withError('Alt kategori bulunamadı.');
            }

            // Servisi güncelliyoruz.
            $service = Service::whereId($id)->update([
                'title' => $request->title,
                'slug' => str()->slug($request->title) . '-' . $serviceExists->id,
                'description' => $request->description,
                'price' => $request->price,

                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'company_id' => $serviceExists->company_id,
                'video_link' => $request->video_link,
                'status' => $request->status
            ]);

            // Dinamik parametreleri güncelle
            if ($request->has('parameters')) {
                try {
                    // Tabloların varlığını kontrol et
                    if (Schema::hasTable('service_parameter_values')) {
                        // Mevcut parametreleri sil
                        ServiceParameterValue::where('service_id', $id)->delete();

                        // Yeni parametreleri ekle
                        foreach ($request->parameters as $paramId => $value) {
                            if (!empty($value)) {
                                ServiceParameterValue::create([
                                    'service_id' => $id,
                                    'category_parameter_id' => $paramId,
                                    'value' => $value
                                ]);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Admin parameter update error: ' . $e->getMessage());
                }
            }




            //            if (!empty($request->sub_categories)) {
            //                $subCategories = [];
            //                foreach ($request->sub_categories as $subCategory) {
            //                    // Alt kategoriler seçilen üst kategoriye ait değilse hata mesajı döndürüyoruz.
            //                    // Kategoriye aitse verileri array içerisinde tutuyoruz.
            //
            //                    if (!Category::whereId($subCategory)->where('parent_id', $request->category_id)->first()) {
            //                        return redirect()->route('company.services.edit', $id)->withError('Kategori bulunamadı.');
            //                    }
            //
            //                    $subCategories[] = ['category_id' => $subCategory, 'service_id' => $id];
            //                }
            //
            //                // Alt kategorileri güncelliyoruz.
            //                ServiceCategory::where('service_id', $id)->delete();
            //                ServiceCategory::insert($subCategories);
            //            }

            // Admin fotoğraf işleme - Yeni ve eski fotoğrafları birleştir
            $photos = [];

            // Yeni yüklenen fotoğraflar
            if ($request->uploaded_files) {
                foreach (explode(',', $request->uploaded_files) as $photo) {
                    if ($photo) {
                        $photos[] = ['path' => $photo, 'service_id' => $id];
                    }
                }
            }

            // Eski fotoğraflar (silinmemiş olanlar)
            if ($request->old_uploaded_files) {
                foreach (explode(',', $request->old_uploaded_files) as $photo2) {
                    if ($photo2) {
                        $photos[] = ['path' => $photo2, 'service_id' => $id];
                    }
                }
            }

            // Mevcut fotoğrafları sil ve yenilerini ekle
            ServiceImage::where('service_id', $id)->delete();
            if (!empty($photos)) {
                ServiceImage::insert($photos);
            }

            DB::commit();
            return redirect()->route('admin.services.index')->withSuccess('Servis güncellendi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.services.edit', $id)->withError('İşlem sırasında bir hata oluştu.
            Lütfen tekrar deneyin.');
        }
    }


    public function adminDestroy($id)
    {
        Service::whereId($id)->delete();
        return redirect()->route('admin.services.index')->withSuccess('İşlem tamamlandı.');
    }


    public function adminReports($status = null)
    {
        if ($status) {
            if (!in_array($status, ['active', 'resolved'])) abort(404);

            $status = $status == 'active' ? 0 : 1;
            $reports = Report::where('status', $status)->where('type', 'service')->orderByDesc('id')->paginate(20);
        } else {
            $reports = Report::orderByDesc('id')->where('type', 'service')->paginate(20);
        }

        return view('admin.services.report', compact('reports'));
    }

    public function adminReportsSolved($id)
    {
        Report::whereId($id)->update(['status' => 1]);
        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }

    /**
     * Kategori parametrelerini getir (AJAX)
     */
    public function getCategoryParameters($categoryId)
    {
        $parameters = CategoryParameter::where('category_id', $categoryId)
            ->active()
            ->ordered()
            ->get();

        return response()->json($parameters);
    }

    /**
     * Servisi onayla
     */
    public function adminConfirm($id)
    {
        $service = Service::with('company.user')->findOrFail($id);
        $service->is_confirmed = 1;
        $service->save();

        // Firma sahibine onay maili ve bildirimi gönder
        if ($service->company && $service->company->user) {
            // Email gönder
            $this->triggerEmailTemplate('service-approved', $service->company->user, [
                'service_title' => $service->title,
                'service_link' => route('services.show', $service->slug),
                'company_name' => $service->company->name,
            ]);

            // Bildirim gönder
            $this->notification('service-approved', $service->company->user_id, [
                'service_title' => $service->title,
                'service_link' => route('services.show', $service->slug),
            ]);
        }

        return redirect()->back()->withSuccess('Servis onaylandı.');
    }

    /**
     * Servis onayını kaldır
     */
    public function adminUnconfirm($id)
    {
        $service = Service::findOrFail($id);
        $service->is_confirmed = 0;
        $service->save();

        return redirect()->back()->withSuccess('Servis onayı kaldırıldı.');
    }
}
