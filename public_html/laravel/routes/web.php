<?php

use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\ProfileController;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\Admin\AnalyticsController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Models\Follower;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\StructureTypeController;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyRating;
use App\Http\Controllers\Admin\ManualBackupController;
use App\Http\Controllers\Admin\StructureClassController;
use App\Http\Controllers\Admin\RoomCountController;
use App\Http\Controllers\Admin\PlanController;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\ChatController;


Route::get('/', [HomeController::class, 'index'])->name('site.home');

Route::get('/storage-link', function () {
    //    Artisan::call('vendor:publish', [
    //        '--provider' => 'Laravel\Fortify\FortifyServiceProvider',
    //    ]);
    //    Artisan::call('cache:clear');
    //    Artisan::call('config:clear');
    //     Artisan::call('cache:clear');
    //     Artisan::call('view:clear');

    //    Artisan::call('storage:link');
    return 'Storage link başarıyla oluşturuldu!';
});

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'Caches cleared';
})->name('clear.cache');

// Bildirim okundu işaretleme (tüm giriş yapmış kullanıcılar için)
Route::post('admin/notifications/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])
    ->name('admin.notifications.read')
    ->middleware('auth');

Route::post('notifications/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])
    ->name('notifications.read')
    ->middleware('auth');

Route::middleware(['auth'])->get('/eplan', [SiteController::class, 'eplan'])->name('company.eplan');

Route::middleware(['auth'])->get('/eplan/{plan}', [SiteController::class, 'eplanShow'])->name('company.eplan.show');

Route::middleware(['auth'])->get('/eplan/{plan}/download', [SiteController::class, 'downloadPlan'])->name('company.eplan.download');
Route::middleware(['auth'])->get('/eplan/{plan}/download-measurement', [SiteController::class, 'downloadMeasurement'])->name('company.eplan.download-measurement');


Route::get('/search', function (\Illuminate\Http\Request $request) {
    $q = $request->query('q');

    if (!$q || strlen($q) < 2) {
        return response()->json([
            'companies' => [],
            'services' => [],
            'ideas' => [],
        ]);
    }

    return response()->json([
        'companies' => \App\Models\Company::where('is_completed', 1)->where('name', 'like', "%$q%")->get(),
        'services' => \App\Models\Service::active()->where('title', 'like', "%$q%")->get(),
        'ideas' => \App\Models\Idea::active()->where('content', 'like', "%$q%")->get(),
    ]);
});

// Admin Paneli
Route::group([
    'middleware' => ['auth', 'checkUserType:admin'],
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::resource('email-templates', EmailTemplateController::class)->except(['show']);


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    // Yedekleme formunu göster
    Route::get('backup', [ManualBackupController::class, 'index'])
        ->name('backup.index');

    // Yedeklemeyi tetikle
    Route::post('backup', [ManualBackupController::class, 'run'])
        ->name('backup.run');

    Route::resource('structure-types', StructureTypeController::class);
    Route::resource('structure-classes', StructureClassController::class);
    Route::resource('room-counts', RoomCountController::class);
    Route::resource('plans', PlanController::class);
    Route::delete('plans/photos/{photo}', [PlanController::class, 'deletePhoto'])->name('plans.photos.delete');
    Route::post('plans/file-upload', [PlanController::class, 'fileUpload'])->name('plans.file-upload');
    Route::post('plans/measurement-file-upload', [PlanController::class, 'measurementFileUpload'])->name('plans.measurement-file-upload');
    Route::delete('plans/{plan}/file-delete', [PlanController::class, 'fileDelete'])->name('plans.file-delete');
    Route::delete('plans/{plan}/measurement-file-delete', [PlanController::class, 'measurementFileDelete'])->name('plans.measurement-file-delete');


    Route::resource('categories', CategoryController::class);

    // Kategori Parametreleri
    Route::prefix('categories/{category}/parameters')->name('categories.parameters.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryParameterController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\CategoryParameterController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CategoryParameterController::class, 'store'])->name('store');
        Route::get('/{parameter}/edit', [\App\Http\Controllers\Admin\CategoryParameterController::class, 'edit'])->name('edit');
        Route::put('/{parameter}', [\App\Http\Controllers\Admin\CategoryParameterController::class, 'update'])->name('update');
        Route::delete('/{parameter}', [\App\Http\Controllers\Admin\CategoryParameterController::class, 'destroy'])->name('destroy');
    });

    //    Route::resource('companies', CompanyController::class);

    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');


    // Slider Routes
    Route::get('sliders', [SettingController::class, 'sliderIndex'])->name('sliders.index');
    Route::get('sliders/create', [SettingController::class, 'sliderCreate'])->name('sliders.create');
    Route::post('sliders', [SettingController::class, 'sliderStore'])->name('sliders.store');
    Route::get('sliders/{slider}/edit', [SettingController::class, 'sliderEdit'])->name('sliders.edit');
    Route::put('sliders/{slider}', [SettingController::class, 'sliderUpdate'])->name('sliders.update');
    Route::delete('sliders/{slider}', [SettingController::class, 'sliderDestroy'])->name('sliders.destroy');


    Route::resource('pages', PageController::class)->except(['show']);

    // E-postaları
    Route::get('emails', [EmailController::class, 'index'])->name('emails.index');
    Route::post('emails', [EmailController::class, 'store'])->name('emails.store');
    Route::delete('emails/{id}', [EmailController::class, 'destroy'])->name('emails.destroy');


    // Kullanıcılar
    Route::get('users/{status?} ', [UserController::class, 'index'])->name('users.index');
    Route::get('users/status/{id} ', [UserController::class, 'status'])->name('users.status');


    // Firmalar
    Route::get('companies/{status?}', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('companies/status/{id} ', [CompanyController::class, 'status'])->name('companies.status');
    //    Route::delete('companies/{id}/delete', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::get('companies/{id}/{status}/verify', [CompanyController::class, 'verifyCompany'])->name('companies.verify');
    Route::post('companies/{id}/extra-right', [CompanyController::class, 'addExtraRight'])->name('companies.extra-right');
    Route::put('companies/packages/{packageId}/edit', [CompanyController::class, 'editPackage'])->name('companies.edit-package');
    Route::delete('companies/packages/{packageId}/delete', [CompanyController::class, 'deletePackage'])->name('companies.delete-package');


    // Firma Paketleri
    Route::resource('packages', PackageController::class)->except(['show']);


    // Satın alınan paketler
    Route::get('purchased-packages/{status?}', [PackageController::class, 'purchasedPackagesIndex'])->name('purchased-packages.index');


    // Satın alma raporları
    Route::get('payments', [PaymentController::class, 'adminIndex'])->name('payments.index');


    // İletişim Mesajları
    Route::get('contacts', [ContactController::class, 'adminIndex'])->name('contacts.index');
    Route::delete('contacts/{id}/delete', [ContactController::class, 'destroy'])->name('contacts.destroy');


    // İletişim
    Route::get('about', [AboutController::class, 'adminIndex'])->name('about.index');
    Route::put('about/1/update', [AboutController::class, 'update'])->name('about.update');

    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics.index');

    Route::post('/analytics/data', [AnalyticsController::class, 'getData'])
        ->name('analytics.data');

    // Analytics AJAX endpoints
    Route::get('/analytics/ideas', [AnalyticsController::class, 'getIdeasData'])
        ->name('analytics.ideas');

    Route::get('/analytics/companies', [AnalyticsController::class, 'getCompaniesData'])
        ->name('analytics.companies');

    Route::get('/analytics/users', [AnalyticsController::class, 'getUsersData'])
        ->name('analytics.users');

    Route::get('/analytics/sliders', [AnalyticsController::class, 'getSlidersData'])
        ->name('analytics.sliders');


    // Servisler
    Route::prefix('services')->name('services.')->controller(ServiceController::class)->group(function () {
        // Servis Şikayetleri
        Route::get('/reports/{status?}', 'adminReports')->name('reports');
        Route::get('/reports/{id}/solved', 'adminReportsSolved')->name('reports.solved');

        Route::get('/{status?}', 'adminIndex')->name('index');
        Route::get('/{id}/edit', 'adminEdit')->name('edit');
        Route::put('/{id}/edit', 'adminUpdate')->name('update');
        Route::delete('/{id}/delete', 'adminDestroy')->name('destroy');

        // Servis onaylama/onayı kaldırma
        Route::post('/{id}/confirm', 'adminConfirm')->name('confirm');
        Route::post('/{id}/unconfirm', 'adminUnconfirm')->name('unconfirm');

        // Admin için kategori parametrelerini getir
        Route::get('/category-parameters/{categoryId}', 'getCategoryParameters')->name('category-parameters');

        // Admin için image upload
        Route::post('/image-upload', 'imageUpload')->name('image-upload');
    });



    // Fikirler
    Route::prefix('ideas')->name('ideas.')->controller(IdeaController::class)->group(function () {
        Route::get('/{status?}', 'adminIndex')->name('index');
        Route::get('/{id}/comments', 'adminComments')->name('comments');
        Route::delete('/{id}/comments/delete', 'adminCommentsDestroy')->name('comments.destroy');
        Route::get('/{id}/status', 'adminStatus')->name('status');
        Route::delete('/{id}/delete', 'adminDestroy')->name('destroy');

        // Fikir onaylama/onayı kaldırma
        Route::post('/{id}/confirm', 'adminConfirm')->name('confirm');
        Route::post('/{id}/unconfirm', 'adminUnconfirm')->name('unconfirm');
    });
});

Route::post('/idea/image-upload', [IdeaController::class, 'uploadImage'])->name('idea.image-upload');
Route::middleware('lastSeen')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check()) {
            $userType = Auth::user()->user_type;

            if ($userType === 'admin') {
                return redirect()->route('admin.dashboard.index');
            } elseif ($userType === 'user') {
                return redirect()->route('user.dashboard');
            } else {
                return redirect()->route('company.profile.edit');
            }
        }

        return redirect()->route('login');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Kullanıcı Paneli (Normal Kullanıcılar İçin)
    Route::group([
        'middleware' => ['auth', 'checkUserType:user'],
        'as' => 'user.',
        'prefix' => 'user'
    ], function () {
        Route::get('/dashboard', function () {
            // Toplam takipçi sayısı ve takipçileri alıyoruz.
            $followersCount = Follower::where('to_id', auth()->user()->id)->count();
            $followers = Follower::query();

            if (request()->follower_name) {
                $followerName = request()->follower_name;

                // Gelen isim değerine göre kullanıcı bilgilerini çekiyoruz.
                $users = \App\Models\UserInformation::select('name', 'user_id', DB::raw("'user' as type"))
                    ->where('name', 'like', '%' . $followerName . '%');

                $companies = \App\Models\Company::select('name', 'user_id', DB::raw("'company' as type"))
                    ->where('name', 'like', '%' . $followerName . '%');

                $results = $users->unionAll($companies)->get();

                $followers = $followers->where('to_id', auth()->user()->id)->whereIn('user_id', $results->pluck('user_id'))
                    ->orderByDesc('id')->paginate(12)->setPageName('followers_page');
            } else {
                $followers = $followers->where('to_id', auth()->user()->id)->orderByDesc('id')
                    ->paginate(12)->setPageName('followers_page');
            }


            // Toplam takip edilen sayısı ve takip edilenleri alıyoruz.
            $followingsCount = Follower::where('user_id', auth()->user()->id)->count();
            $followings = Follower::query();

            if (request()->following_name) {
                $followingName = request()->following_name;

                // Gelen isim değerine göre kullanıcı bilgilerini çekiyoruz.
                $users = \App\Models\UserInformation::select('name', 'user_id', DB::raw("'user' as type"))
                    ->where('name', 'like', '%' . $followingName . '%');

                $companies = \App\Models\Company::select('name', 'user_id', DB::raw("'company' as type"))
                    ->where('name', 'like', '%' . $followingName . '%');

                $results = $users->unionAll($companies)->get();

                $followings = $followings->whereIn('to_id', $results->pluck('user_id'))->where('user_id', auth()->user()->id)
                    ->orderByDesc('id')->paginate(12)->setPageName('followings_page');
            } else {
                $followings = $followings->where('user_id', auth()->user()->id)->paginate(12)->setPageName('followings_page');
            }

            // Oluşturulan fikirleri çekiyoruz.
            $ideaCount = Idea::where('user_id', auth()->user()->id)->count();
            $ideas = Idea::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate(15);

            return view('site.users.dashboard', compact(
                'followers',
                'followersCount',
                'followingsCount',
                'followings',
                'ideaCount',
                'ideas'
            ));
        })->name('dashboard');


        // Profil bilgileri güncelleme
        Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
        Route::delete('/profile/delete', [UserController::class, 'destroy'])->name('profile.destroy');


        // Şifre değiştirme
        Route::get('/change-password', [ProfileController::class, 'userPasswordEdit'])->name('password.edit');
        Route::put('/change-password', [ProfileController::class, 'passwordUpdate'])->name('password.update');


        // Kaydedilen hizmetleri listeleme
        Route::get('/saved-services', [ServiceController::class, 'savedServices'])->name('saved-services');
        Route::get('/saved-services/{id}/delete', [ServiceController::class, 'savedServicesDestroy'])->name('saved-services.destroy');
    });


    // Ortak puanlama rotası (Hem user hem company erişebilir)

    Route::post('/company/rating', function (Request $request) {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
            'company_id' => 'required|exists:companies,id'
        ]);

        $company = Company::find($request->company_id);

        $alreadyRated = $company->ratings()
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyRated) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Bu firmaya zaten puan verdiniz. Her kullanıcı sadece bir kez değerlendirme yapabilir.']);
            }
            return back()->with('error', 'Bu firmaya zaten puan verdiniz. Her kullanıcı sadece bir kez değerlendirme yapabilir.');
        }

        if (auth()->user()->user_type === 'company' && auth()->id() == $company->user_id) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Kendi firmanıza puan veremezsiniz.']);
            }
            return back()->with('error', 'Kendi firmanıza puan veremezsiniz.');
        }

        $newRating = CompanyRating::create([
            'company_id' => $company->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true
        ]);

        if ($request->ajax()) {
            // Yeni değerlendirmeyi ilişkileriyle birlikte al
            $newRating->load(['user.informations', 'user.company']);

            // Kullanıcı bilgilerini düzenle
            $user = $newRating->user;
            $displayName = 'Silinmiş Kullanıcı';
            $avatarPath = 'site/images/default_avatar.jpg';

            if ($user) {
                if ($user->user_type === 'company' && $user->company) {
                    $displayName = $user->company->name ?? $user->name ?? $user->email;
                    $avatarPath = $user->company->avatar ?? $avatarPath;
                } elseif ($user->informations) {
                    $displayName = $user->informations->name ?? $user->name ?? $user->email;
                    $avatarPath = $user->informations->avatar ?? $avatarPath;
                } else {
                    $displayName = $user->name ?? $user->email;
                    $avatarPath = $user->avatar ?? $avatarPath;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Değerlendirmeniz başarıyla gönderildi.',
                'rating' => [
                    'id' => $newRating->id,
                    'rating' => $newRating->rating,
                    'comment' => $newRating->comment,
                    'created_at' => $newRating->created_at,
                    'user' => [
                        'id' => $user->id ?? null,
                        'name' => $user->name ?? null,
                        'email' => $user->email ?? null,
                        'user_type' => $user->user_type ?? null,
                        'display_name' => $displayName,
                        'avatar_path' => $avatarPath,
                        'informations' => $user->informations ?? null,
                        'company' => $user->company ?? null
                    ]
                ]
            ]);
        }
        return back()->with('success', 'Değerlendirmeniz başarıyla gönderildi.');
    })->middleware('auth')->name('company.rating.store');


    Route::delete('/company/rating/{id}', function ($id) {
        $rating = CompanyRating::findOrFail($id);

        // Sadece değerlendirme sahibi veya admin silebilir
        if ($rating->user_id != auth()->id() && auth()->user()->user_type !== 'admin') {
            abort(403, 'Bu işlem için yetkiniz yok');
        }

        $rating->delete();

        return back()->with('success', 'Değerlendirme başarıyla silindi');
    })->middleware('auth')->name('company.rating.destroy');

    // Kullanıcı Paneli (Firmalar İçin)
    Route::group([
        'middleware' => ['auth', 'checkUserType:company', 'isCompanyCompleted'],
        'as' => 'company.',
        'prefix' => 'company'
    ], function () {
        Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
            // Toplam takipçi sayısı ve takipçileri alıyoruz.
            $followersCount = Follower::where('to_id', auth()->user()->id)->count();
            $followers = Follower::query();

            if (request()->follower_name) {
                $followerName = request()->follower_name;

                // Gelen isim değerine göre kullanıcı bilgilerini çekiyoruz.
                $users = \App\Models\UserInformation::select('name', 'user_id', DB::raw("'user' as type"))
                    ->where('name', 'like', '%' . $followerName . '%');

                $companies = \App\Models\Company::select('name', 'user_id', DB::raw("'company' as type"))
                    ->where('name', 'like', '%' . $followerName . '%');

                $results = $users->unionAll($companies)->get();

                $followers = $followers->where('to_id', auth()->user()->id)->whereIn('user_id', $results->pluck('user_id'))
                    ->orderByDesc('id')->paginate(12)->setPageName('followers_page');
            } else {
                $followers = $followers->where('to_id', auth()->user()->id)->orderByDesc('id')
                    ->paginate(12)->setPageName('followers_page');
            }


            // Toplam takip edilen sayısı ve takip edilenleri alıyoruz.
            $followingsCount = Follower::where('user_id', auth()->user()->id)->count();
            $followings = Follower::query();

            if (request()->following_name) {
                $followingName = request()->following_name;

                // Gelen isim değerine göre kullanıcı bilgilerini çekiyoruz.
                $users = \App\Models\UserInformation::select('name', 'user_id', DB::raw("'user' as type"))
                    ->where('name', 'like', '%' . $followingName . '%');

                $companies = \App\Models\Company::select('name', 'user_id', DB::raw("'company' as type"))
                    ->where('name', 'like', '%' . $followingName . '%');

                $results = $users->unionAll($companies)->get();

                $followings = $followings->whereIn('to_id', $results->pluck('user_id'))->where('user_id', auth()->user()->id)
                    ->orderByDesc('id')->paginate(12)->setPageName('followings_page');
            } else {
                $followings = $followings->where('user_id', auth()->user()->id)->paginate(12)->setPageName('followings_page');
            }


            // Oluşturulan hizmetleri çekiyoruz.
            $services = \App\Models\Service::query();
            switch ($request->order_by) {
                case 'price_asc':
                    $services = $services->orderBy('price', 'ASC');
                    break;

                case 'price_desc':
                    $services = $services->orderByDesc('price');
                    break;

                case 'date_desc':
                    $services = $services->orderByDesc('created_at');
                    break;

                case 'date_asc':
                    $services = $services->orderBy('created_at', 'ASC');
                    break;
            }

            // Servisleri ve toplam servis sayısını alıyoruz.
            $services = $services->active()->where('company_id', auth()->user()->company->id)
                ->withCount(['views as view_count' => function ($query) {
                    $query->where('type', 'service');
                }])
                ->orderByDesc('id');
            $serviceCount = $services->count();
            $services = $services->paginate(20, ['*'], 'services_page')->withQueryString();


            // Hizmetlere gelen soruları çekiyoruz.
            $questions = \App\Models\ServiceQuestion::orderByDesc('id')->paginate(12, ['*'], 'questions_page');


            // Analiz verilerini alıyoruz.
            // Seçilen gün değerini değişkene atıyoruz.
            $viewDay = $request->day && in_array($request->day, [1, 7, 30, 90]) ? $request->day : 1;
            $date = $request->day && in_array($request->day, [1, 7, 30, 90]) ? \Carbon\Carbon::now()->subDays($viewDay)
                : \Carbon\Carbon::now()->subDay();


            // Şu anki tarih ile seçilen gün kadar önceki tarih arasındaki verilerin sayısını alıyoruz.
            $profileCurrentCount = \App\Models\View::where('to_id', auth()->user()->company->id)->where('type', 'profile')
                ->whereBetween('created_at', [$date, now()])->count();

            // seçilen gün kadar önceki tarih ile o tarihin de öncesindeki tarihteki verilerin sayısını alıyoruz.
            // Örnek: $date değeri 7 ise 14 gün ile 7 gün önceki tarihlerin arasındaki verileri alıyoruz.
            $profileOldCount = \App\Models\View::where('to_id', auth()->user()->company->id)->where('type', 'profile')
                ->whereBetween('created_at', [$date->subDays($viewDay), $date])->count();


            // Servis id değeri varsa o servise ait verileri alıyoruz. Yoksa tüm servislere ait verileri alıyoruz.
            // Servisin varlığını kontrol ediyoruz.
            if ($request->service && \App\Models\Service::active()->whereId($request->service)->where('company_id', auth()->user()->company->id)->first()) {
                // Şu anki tarih ile seçilen gün kadar önceki tarih arasındaki verilerin sayısını alıyoruz.
                $serviceCurrentCount = \App\Models\View::where('to_id', $request->service)->where('type', 'service')
                    ->whereBetween('created_at', [$date, now()])->count();

                // seçilen gün kadar önceki tarih ile o tarihin de öncesindeki tarihteki verilerin sayısını alıyoruz.
                // Örnek: $date değeri 7 ise 14 gün ile 7 gün önceki tarihlerin arasındaki verileri alıyoruz.
                $serviceOldCount = \App\Models\View::where('to_id', $request->service)->where('type', 'service')
                    ->whereBetween('created_at', [$date->subDays($viewDay), $date])->count();
            } else {
                // Şu anki tarih ile seçilen gün kadar önceki tarih arasındaki verilerin sayısını alıyoruz.
                $serviceCurrentCount = \App\Models\View::whereIn('to_id', $services->pluck('id')->toArray())->where('type', 'service')
                    ->whereBetween('created_at', [$date, now()])->count();

                // seçilen gün kadar önceki tarih ile o tarihin de öncesindeki tarihteki verilerin sayısını alıyoruz.
                // Örnek: $date değeri 7 ise 14 gün ile 7 gün önceki tarihlerin arasındaki verileri alıyoruz.
                $serviceOldCount = \App\Models\View::whereIn('to_id', $services->pluck('id')->toArray())->where('type', 'service')
                    ->whereBetween('created_at', [$date->subDays($viewDay), $date])->count();
            }


            // Değerlendirme verilerini ekliyoruz
            $ratings = \App\Models\CompanyRating::where('company_id', auth()->user()->company->id)
                ->approved()
                ->with('user')
                ->latest()
                ->paginate(5, ['*'], 'ratings_page');

            $averageRating = auth()->user()->company->averageRating();
            $totalRatings = auth()->user()->company->totalRatings();
            $userRating = auth()->user()->company->userRating();

            return view('site.company.dashboard', compact(
                'followers',
                'followersCount',
                'followingsCount',
                'followings',
                'services',
                'serviceCount',
                'questions',
                'profileCurrentCount',
                'profileOldCount',
                'serviceCurrentCount',
                'serviceOldCount',
                'ratings',
                'averageRating',
                'totalRatings',
                'userRating'
            ));
        })->withoutMiddleware('isCompanyCompleted')->name('dashboard');

        // AJAX route for dashboard analytics filters
        Route::get('/dashboard/analytics', function (\Illuminate\Http\Request $request) {
            // Analiz verilerini alıyoruz.
            // Seçilen gün değerini değişkene atıyoruz.
            $viewDay = $request->day && in_array($request->day, [1, 7, 30, 90]) ? $request->day : 1;
            $date = $request->day && in_array($request->day, [1, 7, 30, 90]) ? \Carbon\Carbon::now()->subDays($viewDay)
                : \Carbon\Carbon::now()->subDay();

            // Şu anki tarih ile seçilen gün kadar önceki tarih arasındaki verilerin sayısını alıyoruz.
            $profileCurrentCount = \App\Models\View::where('to_id', auth()->user()->company->id)->where('type', 'profile')
                ->whereBetween('created_at', [$date, now()])->count();

            // seçilen gün kadar önceki tarih ile o tarihin de öncesindeki tarihteki verilerin sayısını alıyoruz.
            // Örnek: $date değeri 7 ise 14 gün ile 7 gün önceki tarihlerin arasındaki verileri alıyoruz.
            $profileOldCount = \App\Models\View::where('to_id', auth()->user()->company->id)->where('type', 'profile')
                ->whereBetween('created_at', [$date->subDays($viewDay), $date])->count();

            // Oluşturulan hizmetleri çekiyoruz.
            $services = \App\Models\Service::query()->active()->where('company_id', auth()->user()->company->id);

            // Servis id değeri varsa o servise ait verileri alıyoruz. Yoksa tüm servislere ait verileri alıyoruz.
            // Servisin varlığını kontrol ediyoruz.
            if ($request->service && \App\Models\Service::active()->whereId($request->service)->where('company_id', auth()->user()->company->id)->first()) {
                // Şu anki tarih ile seçilen gün kadar önceki tarih arasındaki verilerin sayısını alıyoruz.
                $serviceCurrentCount = \App\Models\View::where('to_id', $request->service)->where('type', 'service')
                    ->whereBetween('created_at', [$date, now()])->count();

                // seçilen gün kadar önceki tarih ile o tarihin de öncesindeki tarihteki verilerin sayısını alıyoruz.
                // Örnek: $date değeri 7 ise 14 gün ile 7 gün önceki tarihlerin arasındaki verileri alıyoruz.
                $serviceOldCount = \App\Models\View::where('to_id', $request->service)->where('type', 'service')
                    ->whereBetween('created_at', [$date->subDays($viewDay), $date])->count();
            } else {
                // Şu anki tarih ile seçilen gün kadar önceki tarih arasındaki verilerin sayısını alıyoruz.
                $serviceCurrentCount = \App\Models\View::whereIn('to_id', $services->pluck('id')->toArray())->where('type', 'service')
                    ->whereBetween('created_at', [$date, now()])->count();

                // seçilen gün kadar önceki tarih ile o tarihin de öncesindeki tarihteki verilerin sayısını alıyoruz.
                // Örnek: $date değeri 7 ise 14 gün ile 7 gün önceki tarihlerin arasındaki verileri alıyoruz.
                $serviceOldCount = \App\Models\View::whereIn('to_id', $services->pluck('id')->toArray())->where('type', 'service')
                    ->whereBetween('created_at', [$date->subDays($viewDay), $date])->count();
            }

            return response()->json([
                'profileCurrentCount' => $profileCurrentCount,
                'profileOldCount' => $profileOldCount,
                'serviceCurrentCount' => $serviceCurrentCount,
                'serviceOldCount' => $serviceOldCount,
                'profilePercentageChange' => analytic_percentage_change($profileOldCount, $profileCurrentCount),
                'servicePercentageChange' => analytic_percentage_change($serviceOldCount, $serviceCurrentCount),
            ]);
        })->withoutMiddleware('isCompanyCompleted')->name('dashboard.analytics');

        Route::get('/verify', [CompanyController::class, 'sendVerify'])->name('send-verify');


        // Profil bilgileri güncelleme
        Route::get('/profile', [CompanyController::class, 'profileEdit'])->withoutMiddleware('isCompanyCompleted')->name('profile.edit');
        Route::patch('/profile', [CompanyController::class, 'profileUpdate'])->withoutMiddleware('isCompanyCompleted')->name('profile.update');
        Route::delete('/profile/delete', [CompanyController::class, 'profileDestroy'])->withoutMiddleware('isCompanyCompleted')->name('profile.destroy');
        Route::post('/auto-renew/toggle', [CompanyController::class, 'toggleAutoRenew'])->withoutMiddleware('isCompanyCompleted')->name('auto-renew.toggle');


        // Şifre değiştirme
        Route::get('/change-password', [ProfileController::class, 'companyPasswordEdit'])->withoutMiddleware('isCompanyCompleted')->name('password.edit');
        Route::put('/change-password', [ProfileController::class, 'passwordUpdate'])->withoutMiddleware('isCompanyCompleted')->name('password.update');


        // Paketlerin listesi
        Route::get('/packages', [PackageController::class, 'packagesIndex'])->name('packages.index');
        Route::post('/packages/category-values', [PackageController::class, 'packageCategoryValues']);
        Route::post('/packages/purchase', [PackageController::class, 'add'])->name('packages.add');
        Route::delete('/packages/{id}/cancel', [PackageController::class, 'cancel'])->name('packages.cancel')
            ->middleware(['auth', 'checkUserType:company', 'isCompanyCompleted']);

        // Aboneliklerim
        Route::get('/subscriptions', [PackageController::class, 'subscriptionsIndex'])->withoutMiddleware('isCompanyCompleted')->name('subscriptions.index');


        // Servisler
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::post('/services/image-upload', [ServiceController::class, 'imageUpload'])->name('services.image-upload');
        Route::get('/services/{id}/status', [ServiceController::class, 'status'])->name('services.status');
        Route::post('/services/{id}/update-price', [ServiceController::class, 'updatePrice'])->name('services.update-price');
        Route::post('/services/search', [ServiceController::class, 'search'])->name('services.search');
        Route::get('/services/rights/{id}', [ServiceController::class, 'getRights'])->name('services.rights');
        Route::get('/services/category-parameters/{categoryId}', [ServiceController::class, 'getCategoryParameters'])
            ->withoutMiddleware(['auth', 'checkUserType', 'isCompanyCompleted', 'lastSeen'])
            ->name('services.category-parameters');


        // Kaydedilen hizmetleri listeleme
        Route::get('/saved-services', [ServiceController::class, 'savedServices'])->withoutMiddleware('isCompanyCompleted')->name('saved-services');
        Route::get('/saved-services/{id}/delete', [ServiceController::class, 'savedServicesDestroy'])
            ->withoutMiddleware('isCompanyCompleted')->name('saved-services.destroy');
    });


    // Ödeme Sayfası
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index')->middleware('auth');
    Route::post('/payment/direct', [PaymentController::class, 'processDirectPayment'])->name('payment.direct')->middleware('auth');
    Route::post('/payment/recalculate-token', [PaymentController::class, 'recalculateToken'])->name('payment.recalculate-token')->middleware('auth');


    // Ödeme Bildirim URL - API'ye taşındı (/api/notification)

    // Ödeme Sonuç Sayfaları
    Route::match(['get', 'post'], '/odeme-basarili', [PaymentController::class, 'success'])->name('payment.success');
    Route::match(['get', 'post'], '/odeme-basarisiz', [PaymentController::class, 'error'])->name('payment.error');

    // PayTR Callback (IPN - Instant Payment Notification)
    Route::post('/paytr/callback', [PaymentController::class, 'transactions'])->name('payment.callback');


    // Google ile giriş
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

    // Facebook ile giriş
    Route::get('/auth/facebook', [FacebookAuthController::class, 'redirectToFacebook']);
    Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);


    // Firmaların listesi
    Route::get('/companies', [CompanyController::class, 'companiesIndex'])->name('companies.index');
    Route::post('/companies/{slug}/report', [CompanyController::class, 'report'])->name('companies.report')->middleware('auth');
    Route::get('/companies/{slug}', [CompanyController::class, 'companyShow'])->name('companies.show');


    Route::prefix('services')->name('services.')->controller(ServiceController::class)->group(function () {
        // Servis Detay
        Route::get('/', [ServiceController::class, 'list'])->name('index');
        Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
        Route::get('/{slug}/save', [ServiceController::class, 'save'])->name('save');

        Route::middleware('auth')->group(function () {
            // Soru-Cevap Alanı
            Route::post('/{slug}/question', [ServiceController::class, 'question'])->name('question');
            Route::post('/{slug}/answer', [ServiceController::class, 'answer'])->name('answer');
            Route::delete('/{slug}/{id}/question/delete', [ServiceController::class, 'questionDestroy'])
                ->name('question.destroy');

            // Servis Şikayeti Oluşturma
            Route::post('/services/{slug}/report', [ServiceController::class, 'report'])->name('report');
        });
    });

    // Firma Takip Etme
    Route::post('/follow', [CompanyController::class, 'follow'])->name('company.follow')->middleware('auth');


    // Fikir İşlemleri
    Route::get('idea/list', [IdeaController::class, 'profileIndex'])->name('idea.profile.index')->middleware('auth');
    Route::get('idea/{id}/status', [IdeaController::class, 'status'])->name('idea.profile.status')->middleware('auth');
    Route::resource('idea', IdeaController::class)->except(['index', 'show'])->middleware('auth');
    Route::get('/idea/like/{slug}', [IdeaController::class, 'ideaLike'])->middleware('auth')->name('like');
    Route::get('/idea/{slug}', [IdeaController::class, 'show'])->name('idea.show');
    Route::get('ideas', [IdeaController::class, 'index'])->name('idea.index');

    // Fikir Yorum İşlemleri
    Route::prefix('idea/reply')->name('idea.reply.')->middleware('auth')->controller(IdeaController::class)->group(function () {
        Route::post('/', 'replyStore')->name('store');
        Route::post('/like/{id?}', 'replyLike')->name('like');
        Route::get('/destroy/{id}', 'replyDestroy')->name('destroy');
    });


    // Sayfalar
    Route::get('p/{slug}', [PageController::class, 'show'])->name('page.index');


    // İletişim
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('contact', [ContactController::class, 'store'])->name('contact.store');


    // Hakkımızda
    Route::get('about', [AboutController::class, 'index'])->name('about.index');


    // Dinamik olarak alt kategorileri çekme
    Route::post('/sub-categories/{category}', function ($category) {
        $subCategories = \App\Models\Category::where('parent_id', $category)->orderBy('order')->get();
        return response()->json($subCategories);
    });

    Route::get('/get-sub-categories/{category}', function ($category) {
        $subCategories = \App\Models\Category::where('parent_id', $category)->orderBy('order')->get();
        return response()->json($subCategories);
    });


    // Dinamik olarak ilçeleri çekme
    Route::match(['get', 'post'], '/districts/{city}', function ($city) {
        $districts = \App\Models\District::where('city_id', $city)->orderBy('name')->get();
        return response()->json($districts);
    });

    Route::get('/get-districts/{city}', function ($city) {
        $districts = \App\Models\District::where('city_id', $city)->orderBy('name')->get();
        return response()->json($districts);
    });


    Route::get('chat/search', function (\Illuminate\Http\Request $request) {
        $query = $request->input('query');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $userResults = App\Models\UserInformation::where('status', 1)
            ->where('user_id', '!=', auth()->user()->id)
            ->where('name', 'like', "%$query%")
            ->get(['user_id', 'name']);

        $companyResults = App\Models\Company::where('status', 1)
            ->where('user_id', '!=', auth()->user()->id)
            ->where('name', 'like', "%$query%")
            ->get(['user_id', 'name']);

        // Hangi modelden geldiğini ayırt etmek için type alanı ekleyelim (isteğe bağlı)
        $userResults->transform(function ($item) {
            $item->type = 'user';
            return $item;
        });

        $companyResults->transform(function ($item) {
            $item->type = 'company';
            return $item;
        });

        $results = $userResults->merge($companyResults);
        return response()->json($results);
    })->middleware('auth')->name('chat.search');


    // Chat route'unu güncelle
    Route::get('/chat/{receiver?}', function ($receiver = null) {
        if ($receiver) {
            // Eğer kullanıcı kendisiyle konuşmaya çalışıyorsa ana sayfaya yönlendir
            if (Auth::id() == $receiver) {
                return redirect('/')->with('error', 'Kendinizle sohbet edemezsiniz.');
            }

            // Alıcı ID'sine sahip kullanıcının var olup olmadığını kontrol et
            $receiverExists = \App\Models\User::where('id', $receiver)->exists();
            if (!$receiverExists) {
                return redirect('/')->with('error', 'Kullanıcı bulunamadı.');
            }
        }

        return view('chat', ['receiver' => $receiver]);
    })->middleware('auth')->name('chat.show');

    // web.php
    Route::delete('/chat/{receiverId}', [ChatController::class, 'destroy'])->name('chat.destroy');
});

// Email Verification Code Routes
Route::post('/auth/send-verification-code', [\App\Http\Controllers\Auth\EmailVerificationCodeController::class, 'sendCode'])->name('auth.send-verification-code');
Route::post('/auth/verify-code', [\App\Http\Controllers\Auth\EmailVerificationCodeController::class, 'verifyCode'])->name('auth.verify-code');

/*
|--------------------------------------------------------------------------
| Cron Job Routes (Güvenlikli)
|--------------------------------------------------------------------------
|
| Bu route'lar cPanel veya harici servislerden cron job çalıştırmak için
| kullanılabilir. .env dosyasındaki CRON_SECRET ile korunur.
|
*/

// Tüm paket yönetim işlemleri (Önerilen)
Route::get('/cron/package-management/{secret}', function ($secret) {
    // Güvenlik kontrolü
    if ($secret !== config('app.cron_secret')) {
        abort(403, 'Unauthorized - Invalid secret key');
    }

    try {
        $results = [];

        // 1. Süresi dolan paketleri pasif yap
        Artisan::call('packages:deactivate-expired');
        $results['deactivate'] = [
            'success' => true,
            'output' => Artisan::output(),
            'time' => now()->format('H:i:s')
        ];

        // 2. Otomatik ödemeleri çek
        Artisan::call('packages:renew-expired');
        $results['renew'] = [
            'success' => true,
            'output' => Artisan::output(),
            'time' => now()->format('H:i:s')
        ];

        return response()->json([
            'success' => true,
            'message' => 'All package management tasks completed successfully',
            'results' => $results,
            'timestamp' => now()->toDateTimeString()
        ]);
    } catch (\Exception $e) {
        \Log::error('Cron job error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'timestamp' => now()->toDateTimeString()
        ], 500);
    }
})->name('cron.package-management');

// Sadece otomatik ödemeleri çek
Route::get('/cron/renew-packages/{secret}', function ($secret) {
    if ($secret !== config('app.cron_secret')) {
        abort(403, 'Unauthorized - Invalid secret key');
    }

    try {
        Artisan::call('packages:renew-expired');

        return response()->json([
            'success' => true,
            'message' => 'Package renewal completed',
            'output' => Artisan::output(),
            'timestamp' => now()->toDateTimeString()
        ]);
    } catch (\Exception $e) {
        \Log::error('Package renewal error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
})->name('cron.renew-packages');

// Sadece süresi dolan paketleri pasif yap
Route::get('/cron/deactivate-expired/{secret}', function ($secret) {
    if ($secret !== config('app.cron_secret')) {
        abort(403, 'Unauthorized - Invalid secret key');
    }

    try {
        Artisan::call('packages:deactivate-expired');

        return response()->json([
            'success' => true,
            'message' => 'Expired packages deactivated',
            'output' => Artisan::output(),
            'timestamp' => now()->toDateTimeString()
        ]);
    } catch (\Exception $e) {
        \Log::error('Package deactivation error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
})->name('cron.deactivate-expired');

require __DIR__ . '/auth.php';
