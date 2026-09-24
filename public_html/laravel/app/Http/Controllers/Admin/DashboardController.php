<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Company;
use App\Models\Service;
use App\Models\Idea;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Toplam sayılar
        $companiesCount = Company::count();
        $servicesCount  = Service::count();
        $ideasCount     = Idea::count();

        // Son 6 aya ait şirket kayıt trendi
        $trendLabels = [];
        $trendData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $trendLabels[] = $month->format('M Y');
            $trendData[] = Company::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Son eklenen kayıtlar (5 adet)
        $recentCompanies = Company::latest()->take(5)->get();
        $recentServices  = Service::latest()->take(5)->get();
        $recentIdeas     = Idea::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'companiesCount',
            'servicesCount',
            'ideasCount',
            'trendLabels',
            'trendData',
            'recentCompanies',
            'recentServices',
            'recentIdeas'
        ));
    }
}
