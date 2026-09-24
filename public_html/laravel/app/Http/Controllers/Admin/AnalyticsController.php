<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Idea;
use App\Models\Company;
use App\Models\User;
use App\Models\Category;
use App\Models\Province;
use App\Models\District;
use App\Models\Slider;
use App\Models\View as ViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Admin analizler sayfası
     */
    public function index(Request $request): View
    {
        // Tarih filtreleri
        $period = $request->get('period', '28'); // Default 28 gün
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Tarih aralığını ve karşılaştırma dönemini belirle
        $comparisonLabel = 'Önceki dönem';

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();

            $daysDiff = round($start->diffInDays($end) + 1);
            $previousStart = $start->copy()->subDays($daysDiff);
            $previousEnd = $end->copy()->subDays($daysDiff);

            $comparisonLabel = $daysDiff == 1 ? 'Önceki gün' : "Önceki $daysDiff gün";
        } else {
            // Özel tarih yoksa period kullan
            $end = Carbon::now();
            $start = match($period) {
                'today' => Carbon::today(),
                '7' => Carbon::now()->subDays(7),
                '28' => Carbon::now()->subDays(28),
                '90' => Carbon::now()->subDays(90),
                '365' => Carbon::now()->subDays(365),
                'lifetime' => null, // Tüm zamanlar
                default => Carbon::now()->subDays(28),
            };

            if ($start) {
                $daysDiff = round($start->diffInDays($end) + 1);
                $previousStart = $start->copy()->subDays($daysDiff);
                $previousEnd = $end->copy()->subDays($daysDiff);

                $comparisonLabel = match($period) {
                    'today' => 'Önceki gün',
                    '7' => 'Önceki 7 gün',
                    '28' => 'Önceki 28 gün',
                    '90' => 'Önceki 90 gün',
                    '365' => 'Önceki 365 gün',
                    default => "Önceki $daysDiff gün",
                };
            } else {
                $previousStart = null;
                $previousEnd = null;
                $comparisonLabel = '-';
            }
        }

        // İstatistikler - Seçili dönem
        $servicesCount = $start
            ? Service::whereBetween('created_at', [$start, $end])->count()
            : Service::count();

        $ideasCount = $start
            ? Idea::whereBetween('created_at', [$start, $end])->count()
            : Idea::count();

        $companiesCount = $start
            ? Company::whereBetween('created_at', [$start, $end])->count()
            : Company::count();

        $usersCount = $start
            ? User::where('user_type', 'user')->whereBetween('created_at', [$start, $end])->count()
            : User::where('user_type', 'user')->count();

        // Ziyaretçi verileri
        $totalVisitors = $start
            ? ViewModel::whereBetween('created_at', [$start, $end])->count()
            : ViewModel::count();

        // Üye olan ziyaretçi = Toplam kayıtlı kullanıcılar (user + company)
        $registeredMembers = $start
            ? User::whereBetween('created_at', [$start, $end])->count()
            : User::count();

        // Bireysel ve Kurumsal kullanıcı sayıları
        $individualMembers = $start
            ? User::where('user_type', 'user')->whereBetween('created_at', [$start, $end])->count()
            : User::where('user_type', 'user')->count();

        $corporateMembers = $start
            ? Company::whereBetween('created_at', [$start, $end])->count()
            : Company::count();

        // Normal ve Pro firma sayıları
        if ($start) {
            $normalCompanies = Company::whereBetween('created_at', [$start, $end])
                ->whereDoesntHave('purchasedPackages')
                ->count();
            $proCompanies = Company::whereBetween('created_at', [$start, $end])
                ->whereHas('purchasedPackages')
                ->count();
        } else {
            $normalCompanies = Company::whereDoesntHave('purchasedPackages')->count();
            $proCompanies = Company::whereHas('purchasedPackages')->count();
        }

        // Karşılaştırma dönemi sayıları
        if ($previousStart && $previousEnd) {
            $servicesPrevious = Service::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $ideasPrevious = Idea::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $companiesPrevious = Company::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $usersPrevious = User::where('user_type', 'user')->whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $visitorsPrevious = ViewModel::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $registeredMembersPrevious = User::whereBetween('created_at', [$previousStart, $previousEnd])->count();

            // Yüzde değişim hesaplama
            $servicesChange = analytic_percentage_change($servicesPrevious, $servicesCount);
            $ideasChange = analytic_percentage_change($ideasPrevious, $ideasCount);
            $companiesChange = analytic_percentage_change($companiesPrevious, $companiesCount);
            $usersChange = analytic_percentage_change($usersPrevious, $usersCount);
            $visitorsChange = analytic_percentage_change($visitorsPrevious, $totalVisitors);
            $registeredMembersChange = analytic_percentage_change($registeredMembersPrevious, $registeredMembers);
        } else {
            // Lifetime için karşılaştırma yok
            $servicesChange = 0;
            $ideasChange = 0;
            $companiesChange = 0;
            $usersChange = 0;
            $visitorsChange = 0;
            $registeredMembersChange = 0;
        }

        // Grafik verileri - Line chart için
        $chartLabels = [];
        $servicesDailyData = [];
        $ideasDailyData = [];
        $usersDailyData = [];
        $companiesDailyData = [];

        if ($start && $end) {
            $daysDiff = round($start->diffInDays($end)) + 1;

            if ($daysDiff <= 31) {
                $currentDate = $start->copy();
                while ($currentDate <= $end) {
                    $chartLabels[] = $currentDate->format('d M');
                    $servicesDailyData[] = Service::whereDate('created_at', $currentDate)->count();
                    $ideasDailyData[] = Idea::whereDate('created_at', $currentDate)->count();
                    $usersDailyData[] = User::where('user_type', 'user')->whereDate('created_at', $currentDate)->count();
                    $companiesDailyData[] = Company::whereDate('created_at', $currentDate)->count();
                    $currentDate->addDay();
                }
            } elseif ($daysDiff <= 90) {
                $interval = ceil($daysDiff / 30);
                $currentDate = $start->copy();
                while ($currentDate <= $end) {
                    $chartLabels[] = $currentDate->format('d M');
                    $intervalEnd = $currentDate->copy()->addDays($interval - 1);
                    if ($intervalEnd > $end) $intervalEnd = $end;
                    $servicesDailyData[] = Service::whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $ideasDailyData[] = Idea::whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $usersDailyData[] = User::where('user_type', 'user')->whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $companiesDailyData[] = Company::whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $currentDate->addDays($interval);
                }
            } else {
                $currentDate = $start->copy()->startOfWeek();
                while ($currentDate <= $end) {
                    $weekEnd = $currentDate->copy()->endOfWeek();
                    if ($weekEnd > $end) $weekEnd = $end;
                    $chartLabels[] = $currentDate->format('d M');
                    $servicesDailyData[] = Service::whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $ideasDailyData[] = Idea::whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $usersDailyData[] = User::where('user_type', 'user')->whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $companiesDailyData[] = Company::whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $currentDate->addWeek();
                }
            }
        } else {
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $chartLabels[] = $date->format('d M');
                $servicesDailyData[] = Service::whereDate('created_at', $date)->count();
                $ideasDailyData[] = Idea::whereDate('created_at', $date)->count();
                $usersDailyData[] = User::where('user_type', 'user')->whereDate('created_at', $date)->count();
                $companiesDailyData[] = Company::whereDate('created_at', $date)->count();
            }
        }

        // Grafik verileri için kategoriler - Seçili dönem için
        $topServiceCategoriesQuery = Service::select('category_id', \DB::raw('count(*) as total'));
        if ($start) {
            $topServiceCategoriesQuery->whereBetween('created_at', [$start, $end]);
        }
        $topServiceCategories = $topServiceCategoriesQuery
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(8)
            ->with('category')
            ->get();

        $topIdeaCategoriesQuery = Idea::select('category_id', \DB::raw('count(*) as total'));
        if ($start) {
            $topIdeaCategoriesQuery->whereBetween('created_at', [$start, $end]);
        }
        $topIdeaCategories = $topIdeaCategoriesQuery
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(8)
            ->with('category')
            ->get();

        // HİZMETLER TABLOSU VERİLERİ (İlk tab PHP ile yüklenir)
        $servicesQuery = Service::with(['company', 'category', 'subCategory', 'province', 'district', 'photos'])
            ->withCount(['views', 'savedServices']);

        // Arama filtresi
        if ($search = $request->get('search')) {
            $search = trim($search);
            if ($search !== '') {
                $servicesQuery->where('title', 'like', "%{$search}%");
            }
        }

        // Kategori filtresi
        if ($categoryId = $request->get('category_id')) {
            $categoryId = trim($categoryId);
            if ($categoryId !== '') {
                $servicesQuery->where('category_id', $categoryId);
            }
        }

        // Alt kategori filtresi
        if ($subCategoryId = $request->get('sub_category_id')) {
            $subCategoryId = trim($subCategoryId);
            if ($subCategoryId !== '') {
                $servicesQuery->where('sub_category_id', $subCategoryId);
            }
        }

        // Tarih aralığı filtresi (Hizmetler için ayrı tarih)
        $serviceStartDate = trim($request->get('service_start_date', ''));
        $serviceEndDate = trim($request->get('service_end_date', ''));
        if ($serviceStartDate !== '' && $serviceEndDate !== '') {
            $servicesQuery->whereBetween('created_at', [
                Carbon::parse($serviceStartDate)->startOfDay(),
                Carbon::parse($serviceEndDate)->endOfDay()
            ]);
        }

        // Görüntülenme filtresi
        if ($viewMin = trim($request->get('view_min', ''))) {
            if ($viewMin !== '') {
                $servicesQuery->has('views', '>=', (int)$viewMin);
            }
        }
        if ($viewMax = trim($request->get('view_max', ''))) {
            if ($viewMax !== '') {
                $servicesQuery->has('views', '<=', (int)$viewMax);
            }
        }

        // Kaydetme filtresi
        if ($saveMin = trim($request->get('save_min', ''))) {
            if ($saveMin !== '') {
                $servicesQuery->has('savedServices', '>=', (int)$saveMin);
            }
        }
        if ($saveMax = trim($request->get('save_max', ''))) {
            if ($saveMax !== '') {
                $servicesQuery->has('savedServices', '<=', (int)$saveMax);
            }
        }

        // İl filtresi
        if ($provinceId = $request->get('province_id')) {
            $provinceId = trim($provinceId);
            if ($provinceId !== '') {
                $servicesQuery->where('province_id', $provinceId);
            }
        }

        // İlçe filtresi
        if ($districtId = $request->get('district_id')) {
            $districtId = trim($districtId);
            if ($districtId !== '') {
                $servicesQuery->where('district_id', $districtId);
            }
        }

        // Durum filtresi
        $status = trim($request->get('status', ''));
        if ($status !== '') {
            $servicesQuery->where('status', $status);
        }

        // Sıralama
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // İzin verilen sıralama alanları
        $allowedSorts = [
            'id', 'title', 'views_count', 'saved_services_count',
            'status', 'created_at', 'category', 'sub_category',
            'province', 'district'
        ];

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // İlişkili tablolara göre sıralama
        if ($sortField === 'category') {
            $servicesQuery->join('categories as sort_category', 'services.category_id', '=', 'sort_category.id')
                ->orderBy('sort_category.name', $sortDirection)
                ->select('services.*');
        } elseif ($sortField === 'sub_category') {
            $servicesQuery->join('categories as sort_sub_category', 'services.sub_category_id', '=', 'sort_sub_category.id')
                ->orderBy('sort_sub_category.name', $sortDirection)
                ->select('services.*');
        } elseif ($sortField === 'province') {
            $servicesQuery->join('provinces as sort_province', 'services.province_id', '=', 'sort_province.id')
                ->orderBy('sort_province.name', $sortDirection)
                ->select('services.*');
        } elseif ($sortField === 'district') {
            $servicesQuery->join('districts as sort_district', 'services.district_id', '=', 'sort_district.id')
                ->orderBy('sort_district.name', $sortDirection)
                ->select('services.*');
        } else {
            // Direkt sıralama
            $servicesQuery->orderBy($sortField, $sortDirection);
        }

        // Sayfalama
        $services = $servicesQuery->paginate(15)->withQueryString();

        // FİLTRE SEÇENEKLERİ
        $categories = Category::whereNull('parent_id')->where('status', 1)->orderBy('order')->get();
        $provinces = Province::orderBy('name')->get();

        // Seçili ile varsa ilçeleri getir
        $districts = [];
        $provinceIdForDistricts = trim($request->get('province_id', ''));
        if ($provinceIdForDistricts !== '') {
            $districts = District::where('city_id', $provinceIdForDistricts)->orderBy('name')->get();
        }

        return view('admin.analytics.index', compact(
            'servicesCount', 'ideasCount', 'companiesCount', 'usersCount',
            'totalVisitors', 'registeredMembers', 'individualMembers', 'corporateMembers',
            'normalCompanies', 'proCompanies',
            'servicesChange', 'ideasChange', 'companiesChange', 'usersChange',
            'visitorsChange', 'registeredMembersChange',
            'topServiceCategories', 'topIdeaCategories',
            'chartLabels', 'servicesDailyData', 'ideasDailyData', 'usersDailyData', 'companiesDailyData',
            'comparisonLabel',
            'start', 'end', 'period',
            'services', 'categories', 'provinces', 'districts',
            'sortField', 'sortDirection'
        ));
    }

    /**
     * AJAX endpoint - Analytics verileri
     */
    public function getData(Request $request)
    {
        // Tarih filtreleri
        $period = $request->get('period', '28');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Tarih aralığını ve karşılaştırma dönemini belirle
        $comparisonLabel = 'Önceki dönem';

        if ($startDate && $endDate) {
            // Custom date range
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();

            // Aralık uzunluğunu hesapla (tam sayı)
            $daysDiff = round($start->diffInDays($end) + 1);

            // Önceki dönem
            $previousStart = $start->copy()->subDays($daysDiff);
            $previousEnd = $end->copy()->subDays($daysDiff);

            $comparisonLabel = $daysDiff == 1 ? 'Önceki gün' : "Önceki $daysDiff gün";
        } else {
            $end = Carbon::now();
            $start = match($period) {
                'today' => Carbon::today(),
                '7' => Carbon::now()->subDays(7),
                '28' => Carbon::now()->subDays(28),
                '90' => Carbon::now()->subDays(90),
                '365' => Carbon::now()->subDays(365),
                'lifetime' => null,
                default => Carbon::now()->subDays(28),
            };

            if ($start) {
                $daysDiff = round($start->diffInDays($end) + 1);
                $previousStart = $start->copy()->subDays($daysDiff);
                $previousEnd = $end->copy()->subDays($daysDiff);

                $comparisonLabel = match($period) {
                    'today' => 'Önceki gün',
                    '7' => 'Önceki 7 gün',
                    '28' => 'Önceki 28 gün',
                    '90' => 'Önceki 90 gün',
                    '365' => 'Önceki 365 gün',
                    default => "Önceki $daysDiff gün",
                };
            } else {
                // Lifetime - karşılaştırma yok
                $previousStart = null;
                $previousEnd = null;
                $comparisonLabel = '-';
            }
        }

        // İstatistikler - Seçili dönem
        $servicesCount = $start
            ? Service::whereBetween('created_at', [$start, $end])->count()
            : Service::count();

        $ideasCount = $start
            ? Idea::whereBetween('created_at', [$start, $end])->count()
            : Idea::count();

        $companiesCount = $start
            ? Company::whereBetween('created_at', [$start, $end])->count()
            : Company::count();

        $usersCount = $start
            ? User::where('user_type', 'user')->whereBetween('created_at', [$start, $end])->count()
            : User::where('user_type', 'user')->count();

        // Ziyaretçi verileri
        $totalVisitors = $start
            ? ViewModel::whereBetween('created_at', [$start, $end])->count()
            : ViewModel::count();

        // Üye olan ziyaretçi = Toplam kayıtlı kullanıcılar (user + company)
        $registeredMembers = $start
            ? User::whereBetween('created_at', [$start, $end])->count()
            : User::count();

        // Bireysel ve Kurumsal kullanıcı sayıları
        $individualMembers = $start
            ? User::where('user_type', 'user')->whereBetween('created_at', [$start, $end])->count()
            : User::where('user_type', 'user')->count();

        $corporateMembers = $start
            ? Company::whereBetween('created_at', [$start, $end])->count()
            : Company::count();

        // Normal ve Pro firma sayıları
        if ($start) {
            $normalCompanies = Company::whereBetween('created_at', [$start, $end])
                ->whereDoesntHave('purchasedPackages')
                ->count();
            $proCompanies = Company::whereBetween('created_at', [$start, $end])
                ->whereHas('purchasedPackages')
                ->count();
        } else {
            $normalCompanies = Company::whereDoesntHave('purchasedPackages')->count();
            $proCompanies = Company::whereHas('purchasedPackages')->count();
        }

        // Karşılaştırma dönemi sayıları
        if ($previousStart && $previousEnd) {
            $servicesPrevious = Service::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $ideasPrevious = Idea::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $companiesPrevious = Company::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $usersPrevious = User::where('user_type', 'user')->whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $visitorsPrevious = ViewModel::whereBetween('created_at', [$previousStart, $previousEnd])->count();
            $registeredMembersPrevious = User::whereBetween('created_at', [$previousStart, $previousEnd])->count();

            // Yüzde değişim hesaplama
            $servicesChange = analytic_percentage_change($servicesPrevious, $servicesCount);
            $ideasChange = analytic_percentage_change($ideasPrevious, $ideasCount);
            $companiesChange = analytic_percentage_change($companiesPrevious, $companiesCount);
            $usersChange = analytic_percentage_change($usersPrevious, $usersCount);
            $visitorsChange = analytic_percentage_change($visitorsPrevious, $totalVisitors);
            $registeredMembersChange = analytic_percentage_change($registeredMembersPrevious, $registeredMembers);
        } else {
            // Lifetime için karşılaştırma yok
            $servicesChange = 0;
            $ideasChange = 0;
            $companiesChange = 0;
            $usersChange = 0;
            $visitorsChange = 0;
            $registeredMembersChange = 0;
        }

        // Grafik verileri - Seçili dönem için günlük/haftalık dağılım
        $chartLabels = [];
        $servicesDailyData = [];
        $ideasDailyData = [];
        $usersDailyData = [];
        $companiesDailyData = [];

        if ($start && $end) {
            $daysDiff = round($start->diffInDays($end)) + 1;

            // 31 gün veya daha az: günlük göster
            if ($daysDiff <= 31) {
                $currentDate = $start->copy();
                while ($currentDate <= $end) {
                    $chartLabels[] = $currentDate->format('d M');
                    $servicesDailyData[] = Service::whereDate('created_at', $currentDate)->count();
                    $ideasDailyData[] = Idea::whereDate('created_at', $currentDate)->count();
                    $usersDailyData[] = User::where('user_type', 'user')->whereDate('created_at', $currentDate)->count();
                    $companiesDailyData[] = Company::whereDate('created_at', $currentDate)->count();
                    $currentDate->addDay();
                }
            }
            // 32-90 gün: her 2-3 günde bir
            elseif ($daysDiff <= 90) {
                $interval = ceil($daysDiff / 30); // Max 30 data point
                $currentDate = $start->copy();
                while ($currentDate <= $end) {
                    $chartLabels[] = $currentDate->format('d M');

                    $intervalEnd = $currentDate->copy()->addDays($interval - 1);
                    if ($intervalEnd > $end) $intervalEnd = $end;

                    $servicesDailyData[] = Service::whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $ideasDailyData[] = Idea::whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $usersDailyData[] = User::where('user_type', 'user')->whereBetween('created_at', [$currentDate, $intervalEnd])->count();
                    $companiesDailyData[] = Company::whereBetween('created_at', [$currentDate, $intervalEnd])->count();

                    $currentDate->addDays($interval);
                }
            }
            // 90+ gün: haftalık
            else {
                $currentDate = $start->copy()->startOfWeek();
                while ($currentDate <= $end) {
                    $weekEnd = $currentDate->copy()->endOfWeek();
                    if ($weekEnd > $end) $weekEnd = $end;

                    $chartLabels[] = $currentDate->format('d M');
                    $servicesDailyData[] = Service::whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $ideasDailyData[] = Idea::whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $usersDailyData[] = User::where('user_type', 'user')->whereBetween('created_at', [$currentDate, $weekEnd])->count();
                    $companiesDailyData[] = Company::whereBetween('created_at', [$currentDate, $weekEnd])->count();

                    $currentDate->addWeek();
                }
            }
        } else {
            // Lifetime - son 30 günü göster
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $chartLabels[] = $date->format('d M');
                $servicesDailyData[] = Service::whereDate('created_at', $date)->count();
                $ideasDailyData[] = Idea::whereDate('created_at', $date)->count();
                $usersDailyData[] = User::where('user_type', 'user')->whereDate('created_at', $date)->count();
                $companiesDailyData[] = Company::whereDate('created_at', $date)->count();
            }
        }

        // Kategori dağılımları - Seçili dönem için
        $topServiceCategoriesQuery = Service::select('category_id', \DB::raw('count(*) as total'));
        if ($start) {
            $topServiceCategoriesQuery->whereBetween('created_at', [$start, $end]);
        }
        $topServiceCategories = $topServiceCategoriesQuery
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(8)
            ->with('category')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->category->name ?? 'Bilinmiyor',
                    'total' => $item->total
                ];
            });

        $topIdeaCategoriesQuery = Idea::select('category_id', \DB::raw('count(*) as total'));
        if ($start) {
            $topIdeaCategoriesQuery->whereBetween('created_at', [$start, $end]);
        }
        $topIdeaCategories = $topIdeaCategoriesQuery
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(8)
            ->with('category')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->category->name ?? 'Bilinmiyor',
                    'total' => $item->total
                ];
            });

        return response()->json([
            'comparisonLabel' => $comparisonLabel,
            'stats' => [
                'services' => [
                    'count' => $servicesCount,
                    'change' => $servicesChange,
                ],
                'ideas' => [
                    'count' => $ideasCount,
                    'change' => $ideasChange,
                ],
                'companies' => [
                    'count' => $companiesCount,
                    'normal' => $normalCompanies,
                    'pro' => $proCompanies,
                    'change' => $companiesChange,
                ],
                'users' => [
                    'count' => $usersCount,
                    'change' => $usersChange,
                ],
                'visitors' => [
                    'total' => $totalVisitors,
                    'change' => $visitorsChange,
                ],
                'registeredMembers' => [
                    'total' => $registeredMembers,
                    'individual' => $individualMembers,
                    'corporate' => $corporateMembers,
                    'change' => $registeredMembersChange,
                ],
            ],
            'charts' => [
                'labels' => $chartLabels,
                'services' => $servicesDailyData,
                'ideas' => $ideasDailyData,
                'users' => $usersDailyData,
                'companies' => $companiesDailyData,
                'serviceCategories' => $topServiceCategories,
                'ideaCategories' => $topIdeaCategories,
            ],
        ]);
    }

    /**
     * AJAX endpoint - Fikirler listesi
     */
    public function getIdeasData(Request $request)
    {
        $ideasQuery = Idea::with(['user.informations', 'category', 'subCategory'])
            ->withCount(['views', 'likes', 'replies']);

        // Arama filtresi
        if ($search = $request->get('search')) {
            $ideasQuery->where('title', 'like', "%{$search}%");
        }

        // Kategori filtresi
        if ($categoryId = $request->get('category_id')) {
            $ideasQuery->where('category_id', $categoryId);
        }

        // Alt kategori filtresi
        if ($subCategoryId = $request->get('sub_category_id')) {
            $ideasQuery->where('sub_category_id', $subCategoryId);
        }

        // Tarih aralığı filtresi
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        if ($startDate && $endDate) {
            $ideasQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Görüntülenme filtresi
        if ($viewMin = $request->get('view_min')) {
            $ideasQuery->has('views', '>=', (int)$viewMin);
        }
        if ($viewMax = $request->get('view_max')) {
            $ideasQuery->has('views', '<=', (int)$viewMax);
        }

        // Beğeni filtresi
        if ($likeMin = $request->get('like_min')) {
            $ideasQuery->has('likes', '>=', (int)$likeMin);
        }
        if ($likeMax = $request->get('like_max')) {
            $ideasQuery->has('likes', '<=', (int)$likeMax);
        }

        // Yorum filtresi
        $replyMin = $request->get('reply_min');
        if ($replyMin !== null && $replyMin !== '') {
            $ideasQuery->has('replies', '>=', (int)$replyMin);
        }
        $replyMax = $request->get('reply_max');
        if ($replyMax !== null && $replyMax !== '') {
            $ideasQuery->has('replies', '<=', (int)$replyMax);
        }

        // Durum filtresi
        if ($request->has('status') && $request->get('status') !== '') {
            $ideasQuery->where('status', $request->get('status'));
        }

        // Sıralama
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // İzin verilen sıralama alanları
        $allowedSorts = [
            'id', 'title', 'views_count', 'likes_count', 'replies_count',
            'status', 'created_at', 'category', 'sub_category'
        ];

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // İlişkili tablolara göre sıralama
        if ($sortField === 'category') {
            $ideasQuery->join('categories as sort_category', 'ideas.category_id', '=', 'sort_category.id')
                ->orderBy('sort_category.name', $sortDirection)
                ->select('ideas.*');
        } elseif ($sortField === 'sub_category') {
            $ideasQuery->join('categories as sort_sub_category', 'ideas.sub_category_id', '=', 'sort_sub_category.id')
                ->orderBy('sort_sub_category.name', $sortDirection)
                ->select('ideas.*');
        } else {
            // Direkt sıralama
            $ideasQuery->orderBy($sortField, $sortDirection);
        }

        // Sayfalama
        $ideas = $ideasQuery->paginate(15)->withQueryString();

        // JSON response
        return response()->json([
            'success' => true,
            'data' => $ideas->map(function ($idea) {
                // Resim öncelik sırası: cover_photo -> path -> null
                $ideaImage = null;
                if ($idea->cover_photo && $idea->cover_photo !== 'null') {
                    $ideaImage = asset($idea->cover_photo);
                } elseif ($idea->path && $idea->path !== 'null') {
                    $ideaImage = asset($idea->path);
                }

                return [
                    'id' => $idea->id,
                    'cover_photo' => $ideaImage,
                    'title' => $idea->title,
                    'content' => $idea->content,
                    'category' => $idea->category->name ?? '-',
                    'sub_category' => $idea->subCategory->name ?? '-',
                    'user_name' => $idea->user->informations->name ?? $idea->user->name ?? '-',
                    'user_avatar' => $idea->user->informations->avatar ?? $idea->user->avatar ?? null,
                    'views_count' => $idea->views_count,
                    'likes_count' => $idea->likes_count,
                    'replies_count' => $idea->replies_count,
                    'status' => $idea->status,
                    'created_at' => $idea->created_at->locale('tr')->translatedFormat('d M Y'),
                    'slug' => $idea->slug,
                ];
            }),
            'pagination' => [
                'current_page' => $ideas->currentPage(),
                'last_page' => $ideas->lastPage(),
                'per_page' => $ideas->perPage(),
                'total' => $ideas->total(),
                'from' => $ideas->firstItem(),
                'to' => $ideas->lastItem(),
            ],
        ]);
    }

    /**
     * AJAX endpoint - Firmalar listesi
     */
    public function getCompaniesData(Request $request)
    {
        $companiesQuery = Company::with(['user', 'category', 'subCategory', 'provinceInfo', 'districtInfo', 'purchasedPackages.package'])
            ->withCount('services');

        // Arama filtresi
        if ($search = $request->get('search')) {
            $companiesQuery->where('name', 'like', "%{$search}%");
        }

        // Kategori filtresi
        if ($categoryId = $request->get('category_id')) {
            $companiesQuery->where('category_id', $categoryId);
        }

        // Alt kategori filtresi
        if ($subCategoryId = $request->get('sub_category_id')) {
            $companiesQuery->where('sub_category_id', $subCategoryId);
        }

        // Tarih aralığı filtresi
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        if ($startDate && $endDate) {
            $companiesQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Görüntülenme filtresi - TODO: Optimize edilmeli
        // Şu an performans için skip edildi, frontend'de filtreleme yapılabilir
        $viewMin = $request->get('view_min');
        $viewMax = $request->get('view_max');

        // İl filtresi
        if ($provinceId = $request->get('province_id')) {
            $companiesQuery->where('province', $provinceId);
        }

        // İlçe filtresi
        if ($districtId = $request->get('district_id')) {
            $companiesQuery->where('district', $districtId);
        }

        // Durum filtresi
        if ($request->has('status') && $request->get('status') !== '') {
            $companiesQuery->where('status', $request->get('status'));
        }

        // Pro üyelik filtresi
        if ($request->has('is_pro') && $request->get('is_pro') !== '') {
            $isPro = (bool)$request->get('is_pro');
            if ($isPro) {
                $companiesQuery->whereHas('purchasedPackages');
            } else {
                $companiesQuery->whereDoesntHave('purchasedPackages');
            }
        }

        // Sıralama
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // İzin verilen sıralama alanları
        $allowedSorts = [
            'id', 'name', 'category', 'sub_category', 'status',
            'created_at', 'province', 'district', 'services_count', 'views_count'
        ];

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // İlişkili tablolara göre sıralama
        if ($sortField === 'category') {
            $companiesQuery->join('categories as sort_category', 'companies.category_id', '=', 'sort_category.id')
                ->orderBy('sort_category.name', $sortDirection)
                ->select('companies.*', \DB::raw('(SELECT COUNT(*) FROM services WHERE services.company_id = companies.id) as services_count'));
        } elseif ($sortField === 'sub_category') {
            $companiesQuery->join('categories as sort_sub_category', 'companies.sub_category_id', '=', 'sort_sub_category.id')
                ->orderBy('sort_sub_category.name', $sortDirection)
                ->select('companies.*', \DB::raw('(SELECT COUNT(*) FROM services WHERE services.company_id = companies.id) as services_count'));
        } elseif ($sortField === 'province') {
            $companiesQuery->join('provinces as sort_province', 'companies.province', '=', 'sort_province.id')
                ->orderBy('sort_province.name', $sortDirection)
                ->select('companies.*', \DB::raw('(SELECT COUNT(*) FROM services WHERE services.company_id = companies.id) as services_count'));
        } elseif ($sortField === 'district') {
            $companiesQuery->join('districts as sort_district', 'companies.district', '=', 'sort_district.id')
                ->orderBy('sort_district.name', $sortDirection)
                ->select('companies.*', \DB::raw('(SELECT COUNT(*) FROM services WHERE services.company_id = companies.id) as services_count'));
        } elseif ($sortField === 'services_count') {
            // Hizmet sayısına göre sıralama
            $companiesQuery->orderBy('services_count', $sortDirection);
        } elseif ($sortField === 'views_count') {
            // Görüntülenme sayısına göre sıralama - views tablosundan subquery ile
            $companiesQuery->leftJoin('users as company_user', 'companies.user_id', '=', 'company_user.id')
                ->leftJoin(\DB::raw('(SELECT to_id, COUNT(*) as view_count FROM views WHERE type = "profile" GROUP BY to_id) as profile_views'), 'company_user.id', '=', 'profile_views.to_id')
                ->orderBy('profile_views.view_count', $sortDirection)
                ->select('companies.*', \DB::raw('(SELECT COUNT(*) FROM services WHERE services.company_id = companies.id) as services_count'));
        } else {
            // Direkt sıralama
            $companiesQuery->orderBy($sortField, $sortDirection);
        }

        // Sayfalama
        $companies = $companiesQuery->paginate(15)->withQueryString();

        // JSON response
        return response()->json([
            'success' => true,
            'data' => $companies->map(function ($company) {
                // Pro mu Normal mi belirle
                $latestPackage = $company->latestActivePackage();
                $packageType = $latestPackage ? 'Pro' : 'Normal';

                // Profile görüntülenme sayısı
                $profileViews = ViewModel::where('type', 'profile')
                    ->where('to_id', $company->user_id)
                    ->count();

                return [
                    'id' => $company->id,
                    'avatar' => $company->avatar ? asset($company->avatar) : null,
                    'name' => $company->name,
                    'category' => $company->category->name ?? '-',
                    'sub_category' => $company->subCategory->name ?? '-',
                    'services_count' => $company->services_count ?? 0,
                    'views_count' => $profileViews,
                    'province' => $company->provinceInfo->name ?? '-',
                    'district' => $company->districtInfo->name ?? '-',
                    'status' => $company->status,
                    'package_type' => $packageType,
                    'created_at' => $company->created_at->locale('tr')->translatedFormat('d M Y'),
                    'slug' => $company->slug,
                ];
            }),
            'pagination' => [
                'current_page' => $companies->currentPage(),
                'last_page' => $companies->lastPage(),
                'per_page' => $companies->perPage(),
                'total' => $companies->total(),
                'from' => $companies->firstItem(),
                'to' => $companies->lastItem(),
            ],
        ]);
    }

    /**
     * AJAX endpoint - Bireysel Üyeler listesi
     */
    public function getUsersData(Request $request)
    {
        $usersQuery = User::where('user_type', 'user')
            ->with(['informations.category', 'informations.subCategory'])
            ->withCount('ideas');

        // Arama filtresi
        if ($search = $request->get('search')) {
            $usersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('informations', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Tarih aralığı filtresi
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        if ($startDate && $endDate) {
            $usersQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Kategori filtresi (user_informations üzerinden)
        if ($categoryId = $request->get('category_id')) {
            $usersQuery->whereHas('informations', function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Alt kategori filtresi
        if ($subCategoryId = $request->get('sub_category_id')) {
            $usersQuery->whereHas('informations', function($q) use ($subCategoryId) {
                $q->where('sub_category_id', $subCategoryId);
            });
        }

        // Durum filtresi
        if ($request->has('status') && $request->get('status') !== '') {
            $usersQuery->where('status', $request->get('status'));
        }

        // Sıralama
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // İzin verilen sıralama alanları
        $allowedSorts = [
            'id', 'name', 'category', 'sub_category', 'status', 'created_at', 'ideas_count'
        ];

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // İlişkili tablolara göre sıralama
        if ($sortField === 'name') {
            $usersQuery->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
                ->orderBy('user_informations.name', $sortDirection)
                ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) as ideas_count'));
        } elseif ($sortField === 'category') {
            $usersQuery->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
                ->leftJoin('categories as sort_category', 'user_informations.category_id', '=', 'sort_category.id')
                ->orderBy('sort_category.name', $sortDirection)
                ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) as ideas_count'));
        } elseif ($sortField === 'sub_category') {
            $usersQuery->leftJoin('user_informations', 'users.id', '=', 'user_informations.user_id')
                ->leftJoin('categories as sort_sub_category', 'user_informations.sub_category_id', '=', 'sort_sub_category.id')
                ->orderBy('sort_sub_category.name', $sortDirection)
                ->select('users.*', \DB::raw('(SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) as ideas_count'));
        } elseif ($sortField === 'ideas_count') {
            // Fikir sayısına göre sıralama
            $usersQuery->orderBy('ideas_count', $sortDirection);
        } else {
            // Direkt sıralama
            $usersQuery->orderBy($sortField, $sortDirection);
        }

        // Sayfalama
        $users = $usersQuery->paginate(15)->withQueryString();

        // JSON response
        return response()->json([
            'success' => true,
            'data' => $users->map(function ($user) {
                // Kategori bilgisi - null-safe
                $categoryName = $user->informations?->category?->name ?? '-';
                $subCategoryName = $user->informations?->subCategory?->name ?? '-';

                return [
                    'id' => $user->id,
                    'avatar' => $user->informations?->avatar ?? $user->avatar ?? null,
                    'name' => $user->informations?->name ?? $user->name,
                    'email' => $user->email ?? '-',
                    'category' => $categoryName,
                    'sub_category' => $subCategoryName,
                    'ideas_count' => $user->ideas_count ?? 0,
                    'status' => $user->status,
                    'created_at' => $user->created_at->locale('tr')->translatedFormat('d M Y'),
                ];
            }),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ],
        ]);
    }

    /**
     * AJAX endpoint - Slaytlar listesi
     */
    public function getSlidersData(Request $request)
    {
        $slidersQuery = Slider::query();

        // Arama filtresi
        if ($search = $request->get('search')) {
            $slidersQuery->where('title', 'like', "%{$search}%");
        }

        // Tarih aralığı filtresi
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        if ($startDate && $endDate) {
            $slidersQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Durum filtresi
        if ($request->has('status') && $request->get('status') !== '') {
            $slidersQuery->where('status', $request->get('status'));
        }

        // Sıralama ve sayfalama
        $sliders = $slidersQuery->orderBy('order', 'asc')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        // JSON response
        return response()->json([
            'success' => true,
            'data' => $sliders->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'image' => $slider->image ? asset($slider->image) : null,
                    'title' => $slider->title,
                    'description' => $slider->description,
                    'button_link' => $slider->button_link,
                    'order' => $slider->order,
                    'status' => $slider->status,
                    'created_at' => $slider->created_at->locale('tr')->translatedFormat('d M Y'),
                ];
            }),
            'pagination' => [
                'current_page' => $sliders->currentPage(),
                'last_page' => $sliders->lastPage(),
                'per_page' => $sliders->perPage(),
                'total' => $sliders->total(),
                'from' => $sliders->firstItem(),
                'to' => $sliders->lastItem(),
            ],
        ]);
    }
}
