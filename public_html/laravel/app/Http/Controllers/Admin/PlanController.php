<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\StructureType;
use App\Models\StructureClass;
use App\Models\RoomCount;
use App\Models\PlanPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class PlanController extends Controller
{
    /**
     * Plan listeleme
     */
    public function index()
    {

        $plans = Plan::with(['structureType', 'structureClass', 'roomCount'])->latest()->get();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Plan ekleme formu
     */
    public function create()
    {
        $types = StructureType::all();
        $classes = StructureClass::all();
        $rooms = RoomCount::all();

        return view('admin.plans.create', compact('types', 'classes', 'rooms'));
    }

    /**
     * Plan kaydetme
     */
    public function store(Request $request)
    {
        $request->validate([
            'structure_type_id' => 'required|exists:structure_types,id',
            'structure_class_id' => 'required|exists:structure_classes,id',
            'room_count_id' => 'required|exists:room_counts,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'net_area' => 'required|string|max:255',
            'gross_area' => 'required|string|max:255',
            'uploaded_file' => 'nullable|string',
            'measurement_uploaded_file' => 'nullable|string',
            'photos.*' => 'nullable|image|max:10240',
        ]);

        // Plan dosyası (dropzone'dan gelen dosya adı)
        $filePath = null;
        if ($request->has('uploaded_file') && !empty($request->uploaded_file)) {
            $filePath = 'uploads/plans/files/' . $request->uploaded_file;
        }

        // Metraj dosyası (dropzone'dan gelen dosya adı)
        $measurementFilePath = null;
        if ($request->has('measurement_uploaded_file') && !empty($request->measurement_uploaded_file)) {
            $measurementFilePath = 'uploads/plans/measurements/' . $request->measurement_uploaded_file;
        }

        $plan = Plan::create([
            'structure_type_id' => $request->structure_type_id,
            'structure_class_id' => $request->structure_class_id,
            'room_count_id' => $request->room_count_id,
            'title' => $request->title,
            'description' => $request->description,
            'net_area' => $request->net_area,
            'gross_area' => $request->gross_area,
            'file_path' => $filePath,
            'measurement_file_path' => $measurementFilePath,
            'status' => 1,
        ]);

        // Çoklu fotoğraf yükle ve optimize et
        if ($request->hasFile('photos')) {
            $uploadPath = base_path('../uploads/plans/photos');
            if (!File::exists($uploadPath)) File::makeDirectory($uploadPath, 0777, true);

            foreach ($request->file('photos') as $photo) {
                try {
                    $fileName = uniqid() . '.webp'; // WebP formatında kaydet
                    $filePath = $uploadPath . '/' . $fileName;

                    // Görsel optimizasyonu - en-boy oranını koruyarak
                    $this->optimizeImage($photo->getPathname(), $filePath);

                    PlanPhoto::create([
                        'plan_id' => $plan->id,
                        'path' => 'uploads/plans/photos/' . $fileName,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Fotoğraf yükleme hatası', [
                        'plan_id' => $plan->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plan başarıyla eklendi.');
    }

    /**
     * Plan düzenleme formu
     */
    public function edit($id)
    {
        $plan = Plan::with('photos')->findOrFail($id);

        // Gerekli parametreler
        $structureTypes = StructureType::all();
        $structureClasses = StructureClass::all();
        $roomCounts = RoomCount::all();

        return view('admin.plans.edit', compact(
            'plan',
            'structureTypes',
            'structureClasses',
            'roomCounts'
        ));
    }

    /**
     * Plan güncelleme
     */
    public function update(Request $request, $id)
    {
        // Sadece PUT/PATCH method ile çağrılırsa güncelle
        if (!in_array($request->method(), ['PUT', 'PATCH'])) {
            \Log::error('PLAN UPDATE BLOCKED - Wrong method', [
                'plan_id' => $id,
                'method' => $request->method(),
                'intended_methods' => ['PUT', 'PATCH']
            ]);
            abort(405, 'Method not allowed');
        }

        try {
            $plan = Plan::findOrFail($id);

            // Debug: Request verilerini logla
            \Log::info('Plan Update Request', [
                'plan_id' => $id,
                'all_data' => $request->all(),
                'has_photos' => $request->hasFile('photos'),
                'photo_count' => $request->hasFile('photos') ? count($request->file('photos')) : 0
            ]);

            // Validation
            $validatedData = $request->validate([
                'structure_type_id' => 'required|integer',
                'structure_class_id' => 'required|integer',
                'room_count_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'net_area' => 'nullable|string|max:255',
                'gross_area' => 'nullable|string|max:255',
                'uploaded_file' => 'nullable|string',
                'measurement_uploaded_file' => 'nullable|string',
                'photos.*' => 'nullable|image|max:10240',
            ]);

            // Dropzone dosyası varsa işle
            $updateData = [
                'structure_type_id' => $request->structure_type_id,
                'structure_class_id' => $request->structure_class_id,
                'room_count_id' => $request->room_count_id,
                'title' => $request->title,
                'description' => $request->description,
                'net_area' => $request->net_area,
                'gross_area' => $request->gross_area,
            ];

            if ($request->has('uploaded_file') && !empty($request->uploaded_file)) {
                $updateData['file_path'] = 'uploads/plans/files/' . $request->uploaded_file;
            }

            if ($request->has('measurement_uploaded_file') && !empty($request->measurement_uploaded_file)) {
                $updateData['measurement_file_path'] = 'uploads/plans/measurements/' . $request->measurement_uploaded_file;
            }

            // Tüm alanları güncelle (dosya dahil)
            $plan->update($updateData);

            // Yeni fotoğraflar yükle
            if ($request->hasFile('photos')) {
                \Log::info('Fotoğraf yükleme başladı', [
                    'plan_id' => $plan->id,
                    'photo_count' => count($request->file('photos'))
                ]);

                $uploadPath = base_path('../uploads/plans/photos');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true);
                }

                foreach ($request->file('photos') as $photo) {
                    try {
                        $fileName = uniqid() . '.webp'; // WebP formatında kaydet
                        $filePath = $uploadPath . '/' . $fileName;

                        // Görsel optimizasyonu - en-boy oranını koruyarak
                        $this->optimizeImage($photo->getPathname(), $filePath);

                        PlanPhoto::create([
                            'plan_id' => $plan->id,
                            'path' => 'uploads/plans/photos/' . $fileName,
                        ]);

                        \Log::info('Fotoğraf yüklendi ve optimize edildi', [
                            'plan_id' => $plan->id,
                            'filename' => $fileName,
                            'path' => 'uploads/plans/photos/' . $fileName
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Fotoğraf yükleme hatası', [
                            'plan_id' => $plan->id,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                \Log::info('Fotoğraf yükleme tamamlandı', [
                    'plan_id' => $plan->id,
                    'uploaded_photos' => count($request->file('photos'))
                ]);
            }

            return redirect()->route('admin.plans.edit', $plan->id)->with('success', 'Plan başarıyla güncellendi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Plan Update Validation Error', [
                'plan_id' => $id,
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Plan Update Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Güncelleme sırasında hata oluştu: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Plan silme
     */
    public function destroy($id)
    {
        \Log::warning('PLAN DELETE CALLED!', [
            'plan_id' => $id,
            'method' => request()->method(),
            'route' => request()->route()->getName(),
            'user_agent' => request()->userAgent(),
            'url' => request()->url(),
            'referer' => request()->header('referer')
        ]);

        // Sadece DELETE method ile çağrılırsa sil
        if (request()->method() !== 'DELETE') {
            \Log::error('PLAN DELETE BLOCKED - Wrong method', [
                'plan_id' => $id,
                'method' => request()->method(),
                'intended_method' => 'DELETE'
            ]);
            abort(405, 'Method not allowed');
        }

        $plan = Plan::findOrFail($id);

        // Dosya sil
        if ($plan->file_path) {
            Storage::disk('public')->delete($plan->file_path);
        }

        // Fotoğrafları sil
        foreach ($plan->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan silindi.');
    }

    public function deletePhoto($photoId)
    {
        $photo = PlanPhoto::findOrFail($photoId);

        // Fotoğraf dosyasını sil
        if ($photo->path && Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();

        return redirect()->back()->with('success', 'Fotoğraf başarıyla silindi.');
    }

    /**
     * Plan dosyası yükleme (Dropzone için)
     */
    public function fileUpload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:zip,rar,pdf|max:20480', // 20MB
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = base_path('../uploads/plans/files');

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true);
                }

                $file->move($uploadPath, $filename);

                return response()->json([
                    'success' => true,
                    'fileName' => $filename,
                    'originalName' => $file->getClientOriginalName(),
                    'filePath' => 'uploads/plans/files/' . $filename
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Dosya bulunamadı'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Plan dosyası silme
     */
    public function fileDelete(Plan $plan)
    {
        try {
            if ($plan->file_path) {
                $filePath = base_path('../' . $plan->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $plan->file_path = null;
                $plan->save();

                return response()->json(['success' => true, 'message' => 'Dosya başarıyla silindi']);
            }

            return response()->json(['success' => false, 'message' => 'Silinecek dosya bulunamadı'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Metraj dosyası yükleme (Dropzone için)
     */
    public function measurementFileUpload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:zip,rar,pdf|max:20480', // 20MB
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = base_path('../uploads/plans/measurements');

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true);
                }

                $file->move($uploadPath, $filename);

                return response()->json([
                    'success' => true,
                    'fileName' => $filename,
                    'originalName' => $file->getClientOriginalName(),
                    'filePath' => 'uploads/plans/measurements/' . $filename
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Dosya bulunamadı'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Metraj dosyası silme
     */
    public function measurementFileDelete(Plan $plan)
    {
        try {
            if ($plan->measurement_file_path) {
                $filePath = base_path('../' . $plan->measurement_file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $plan->measurement_file_path = null;
                $plan->save();

                return response()->json(['success' => true, 'message' => 'Metraj dosyası başarıyla silindi']);
            }

            return response()->json(['success' => false, 'message' => 'Silinecek metraj dosyası bulunamadı'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Görsel optimizasyonu - en-boy oranını koruyarak
     */
    private function optimizeImage($sourcePath, $targetPath, $maxWidth = 1200, $maxHeight = 1200, $quality = 85)
    {
        try {
            // Dosya tipini belirle
            $imageInfo = getimagesize($sourcePath);
            if (!$imageInfo) {
                throw new \Exception('Geçersiz görsel dosyası');
            }

            $originalWidth = $imageInfo[0];
            $originalHeight = $imageInfo[1];
            $mimeType = $imageInfo['mime'];

            // Kaynak görseli yükle
            switch ($mimeType) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($sourcePath);
                    break;
                case 'image/webp':
                    $sourceImage = imagecreatefromwebp($sourcePath);
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($sourcePath);
                    break;
                default:
                    throw new \Exception('Desteklenmeyen görsel formatı: ' . $mimeType);
            }

            if (!$sourceImage) {
                throw new \Exception('Görsel yüklenemedi');
            }

            // En-boy oranını koruyarak yeni boyutları hesapla
            $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);

            // Eğer görsel zaten küçükse, orijinal boyutları koru
            if ($ratio >= 1) {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            } else {
                $newWidth = (int)($originalWidth * $ratio);
                $newHeight = (int)($originalHeight * $ratio);
            }

            // Yeni görsel oluştur
            $targetImage = imagecreatetruecolor($newWidth, $newHeight);

            // PNG ve WebP için şeffaflığı koru
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
            imagefill($targetImage, 0, 0, $transparent);

            // Görseli yeniden boyutlandır (en-boy oranını koruyarak)
            imagecopyresampled(
                $targetImage,
                $sourceImage,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $originalWidth,
                $originalHeight
            );

            // Watermark ekle (ServiceController ile aynı mantık)
            try {
                $host = parse_url(env('APP_URL'), PHP_URL_HOST);
                $watermarkText = 'www.' . $host;
                $fontPath = public_path('assets/site/fonts/Roboto-Bold.ttf');
                $angle = -25;
                $fontSize = 24; // ServiceController ile aynı boyut

                if ($host && file_exists($fontPath)) {
                    // Filigran eklerken alpha blending'i aç (saydamlık için gerekli)
                    imagealphablending($targetImage, true);

                    // Renk: yarı saydam beyaz
                    $color = imagecolorallocatealpha($targetImage, 255, 255, 255, 90); // 0 opak, 127 şeffaf (90 = daha saydam)

                    // Metnin bounding box'unu al
                    $bbox = imagettfbbox($fontSize, $angle, $fontPath, $watermarkText);
                    if ($bbox !== false) {
                        $textWidth = max($bbox[2], $bbox[4]) - min($bbox[0], $bbox[6]);
                        $textHeight = max($bbox[1], $bbox[3]) - min($bbox[5], $bbox[7]);

                        // Ortalamak için başlangıç koordinatları
                        $x = (int)(($newWidth - $textWidth) / 2);
                        // Dikey olarak tam ortalamak için baseline offset'ini hesapla
                        $baselineOffset = abs($bbox[7]); // Alt kısımdan baseline'a olan mesafe
                        $y = (int)(($newHeight / 2) + ($textHeight / 2) - $baselineOffset - ($textHeight * 0.3));

                        imagettftext($targetImage, $fontSize, $angle, $x, $y, $color, $fontPath, $watermarkText);
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('Plan watermark eklenirken hata: ' . $e->getMessage(), [
                    'source_path' => $sourcePath,
                    'target_path' => $targetPath
                ]);
            }

            // WebP formatında kaydet
            $result = imagewebp($targetImage, $targetPath, $quality);

            // Belleği temizle
            imagedestroy($sourceImage);
            imagedestroy($targetImage);

            if (!$result) {
                throw new \Exception('WebP kaydetme hatası');
            }

            \Log::info('Görsel optimize edildi', [
                'original_size' => $originalWidth . 'x' . $originalHeight,
                'new_size' => $newWidth . 'x' . $newHeight,
                'original_format' => $mimeType,
                'target_format' => 'image/webp',
                'target_path' => $targetPath
            ]);
        } catch (\Exception $e) {
            \Log::error('Görsel optimizasyon hatası', [
                'source_path' => $sourcePath,
                'target_path' => $targetPath,
                'error' => $e->getMessage()
            ]);

            // Hata durumunda orijinal dosyayı kopyala
            copy($sourcePath, $targetPath);
        }
    }
}
