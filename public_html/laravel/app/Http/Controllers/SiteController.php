<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProPackageCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\StructureType;
use App\Models\StructureClass;
use App\Models\RoomCount;
use App\Models\Plan;

class SiteController extends Controller
{

    public function eplan(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->company) {
            abort(403, 'Erişim reddedildi');
        }

        $company = $user->company;
        $latestPackage = $company->latestActivePackage();

        if (!$latestPackage) {
            abort(403, 'Aktif paket bulunamadı');
        }

        $hasEplanAccess = ProPackageCategory::where('pro_package_id', $latestPackage->id)
            ->where('eplan_preview', 1)
            ->exists();

        if (!$hasEplanAccess) {
            abort(403, 'E-Plan yetkiniz yok');
        }

        $plans = Plan::query()
            ->when($request->structure_type_id, fn($q) => $q->where('structure_type_id', $request->structure_type_id))
            ->when($request->structure_class_id, fn($q) => $q->where('structure_class_id', $request->structure_class_id))
            ->when($request->room_count_id, fn($q) => $q->where('room_count_id', $request->room_count_id))
            ->when($request->min_area, fn($q) => $q->where('gross_area', '>=', $request->min_area))
            ->when($request->max_area, fn($q) => $q->where('gross_area', '<=', $request->max_area))
            ->with('photos')
            ->paginate(20);

        $structureTypes = StructureType::all();
        $structureClasses = StructureClass::all();
        $roomCounts = RoomCount::all();

        return view('site.company.eplan', compact('plans', 'structureTypes', 'structureClasses', 'roomCounts'));
    }
    public function eplanShow(Plan $plan)
    {
        // Plan ile birlikte ilişkili verileri yükle
        $plan->load(['structureType', 'structureClass', 'roomCount', 'photos']);
        
        // Benzer planları getir (aynı yapı türü veya sınıfından, mevcut plan hariç)
        $similarPlans = Plan::where('id', '!=', $plan->id)
            ->where(function($query) use ($plan) {
                $query->where('structure_type_id', $plan->structure_type_id)
                      ->orWhere('structure_class_id', $plan->structure_class_id)
                      ->orWhere('room_count_id', $plan->room_count_id);
            })
            ->with(['structureType', 'structureClass', 'roomCount', 'photos'])
            ->limit(10)
            ->get();
        
        return view('site.company.eplan-show', compact('plan', 'similarPlans'));
    }

    public function downloadPlan(Plan $plan)
    {
        // Check if plan has a file
        if (!$plan->file_path) {
            abort(404, 'Plan dosyası bulunamadı.');
        }

        // Build the full file path
        $filePath = base_path('../' . $plan->file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'Plan dosyası bulunamadı.');
        }

        // Get the original filename from the path
        $fileName = basename($plan->file_path);
        
        // Create a more user-friendly filename
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $friendlyName = $plan->title . '.' . $extension;

        // Return file download response
        return response()->download($filePath, $friendlyName);
    }

    public function downloadMeasurement(Plan $plan)
    {
        // Check if plan has a measurement file
        if (!$plan->measurement_file_path) {
            abort(404, 'Bu plan için metraj dosyası yüklenmemiş.');
        }

        // Build the full file path
        $filePath = base_path('../' . $plan->measurement_file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'Metraj dosyası bulunamadı.');
        }

        // Get the original filename from the path
        $fileName = basename($plan->measurement_file_path);
        
        // Create a more user-friendly filename
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $friendlyName = $plan->title . '_Metraj.' . $extension;

        // Return file download response
        return response()->download($filePath, $friendlyName);
    }


}
