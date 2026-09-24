<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Idea;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Kategorileri cache'den al (30 dakika)
        $categories = Cache::remember('home_categories', 1800, function () {
            return Category::where('status', 1)->whereNull('parent_id')->orderBy('order')->get();
        });

        // En popüler 6 servisi cache'den al (15 dakika)
        $services = Cache::remember('home_popular_services', 900, function () {
            $services = Service::active()->confirmed()
                ->with(['category', 'subCategory', 'photos'])
                ->get();

            $serviceModel = new Service();
            foreach ($services as $service) {
                $service->view_count = $serviceModel->serviceViewCount($service->id);
            }

            return $services->sortByDesc('view_count')->take(6);
        });

        // Son 6 fikri cache'den al (10 dakika)
        $ideas = Cache::remember('home_latest_ideas', 600, function () {
            return Idea::active()->confirmed()
                ->with(['category', 'subCategory', 'user'])
                ->orderByDesc('id')
                ->limit(6)
                ->get();
        });

        // Son 6 firmayı cache'den al (15 dakika)
        $companies = Cache::remember('home_featured_companies', 900, function () {
            return Company::active()
                ->with(['ratings', 'category', 'subCategory'])
                ->orderByDesc('id')
                ->limit(6)
                ->get();
        });

        return view('site.index', compact('categories', 'services', 'ideas', 'companies'));
    }
}
