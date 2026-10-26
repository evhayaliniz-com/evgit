<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Models\Category;
use App\Models\Idea;
use App\Models\IdeaReply;
use App\Models\IdeaReplyLike;
use App\Models\IdeaLike;
use Illuminate\Http\Request;
use App\Mail\AdminNewIdeaNotification;
use App\Traits\AdminNotificationTrait;
use App\Traits\NotificationTrait;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Traits\EmailTemplateTrait;
use App\Helpers\CacheHelper;

class IdeaController extends Controller
{
    use NotificationTrait, EmailTemplateTrait, AdminNotificationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = Idea::query();

        // Filtreleme işlemleri
        if ($request->category) {
            $ideas = $ideas->where('category_id', $request->category);
        }

        if ($request->sub_category) {
            $subCategories = is_array($request->sub_category) ? $request->sub_category : explode(',', (string)$request->sub_category);
            $subCategories = array_values(array_filter($subCategories));
            if (!empty($subCategories)) {
                $ideas = $ideas->whereIn('sub_category_id', $subCategories);
            }
        }

        if ($request->author_type) {
            if ($request->author_type === 'company') {
                $ideas = $ideas->whereHas('user', function ($query) {
                    $query->where('user_type', 'company');
                });
            } elseif ($request->author_type === 'user') {
                $ideas = $ideas->whereHas('user', function ($query) {
                    $query->where('user_type', '!=', 'company');
                });
            }
        }

        if ($request->q) {
            $searchTerm = trim($request->q);
            $ideas = $ideas->where(function ($query) use ($searchTerm) {
                $query->where('content', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('title', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $ideaCount = (clone $ideas)->active()->confirmed()->count();

        $ideas = $ideas->active()->confirmed()
            ->with(['category', 'subCategory', 'user.company', 'user.informations'])
            ->withCount([
                'views as view_count' => function ($q) {
                    $q->where('type', 'idea');
                },
                'likes as like_count',
                'replies as reply_count'
            ]);

        // Akıllı sıralama işlemi
        if ($request->order_by) {
            switch ($request->order_by) {
                case 'views_desc':
                    $ideas = $ideas->orderByDesc('view_count')->orderByDesc('id');
                    break;
                case 'likes_desc':
                    $ideas = $ideas->orderByDesc('like_count')->orderByDesc('id');
                    break;
                case 'comments_desc':
                    $ideas = $ideas->orderByDesc('reply_count')->orderByDesc('id');
                    break;
                case 'oldest':
                    $ideas = $ideas->orderBy('id', 'ASC');
                    break;
                default:
                    $ideas = $ideas->orderByDesc('id');
                    break;
            }
        } else {
            $ideas = $ideas->orderByDesc('id');
        }

        $ideas = $ideas->paginate(20)->withQueryString();

        return view('site.idea.index', compact('ideas', 'ideaCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('site.idea.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request)
    {


        $paths = [];

        // Dropzone'dan gelen dosya yollarını alıyoruz
        if (!empty($request->uploaded_files)) {
            $dropzoneFiles = explode(',', $request->uploaded_files);

            foreach ($dropzoneFiles as $file) {
                $trimmed = trim($file);
                if (!empty($trimmed)) {
                    $paths[] = $trimmed;
                }
            }
        }

        // Alt kategori kontrolü
        if ($request->category_id && $request->sub_category_id) {
            $categoryExists = Category::select('id')
                ->whereId($request->sub_category_id)
                ->where('parent_id', $request->category_id)
                ->where('status', 1)
                ->first();

            if (!$categoryExists) {
                return redirect()->back()->withError('Kategori bulunamadı.');
            }
        }

        // Kayıt oluşturuluyor
        /** @var Idea $idea */
        $idea = Idea::create([
            'content' => $request->post('content'),
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'path' => !empty($paths) ? json_encode($paths) : null,
            'user_id' => auth()->id(),
            'status' => $request->status
        ]);

        // Slug güncelle
        $idea->slug = str()->slug(str()->limit($idea->content, 30, '')) . '-' . $idea->id;
        $idea->save();
        $idea->loadMissing(['category', 'subCategory', 'user']);

        // Admin'lere email gönder
        $this->notifyAdmins(new AdminNewIdeaNotification($idea, auth()->user()));

        // Admin'lere bildirim oluştur
        $ideaPreview = (string) Str::of($idea->content ?? 'Yeni fikir')
            ->squish()
            ->limit(80);

        $this->createAdminNotifications(
            'Yeni fikir paylaşıldı: ' . $ideaPreview,
            route('admin.ideas.index'),
            auth()->id()
        );

        // Cache'i temizle
        CacheHelper::clearIdeaCache();

        return redirect()->route('idea.profile.index')->withSuccess('İşlem tamamlandı.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            $targetPath = base_path('../uploads/ideas');
            if (!file_exists($targetPath)) {
                mkdir($targetPath, 0755, true);
            }

            $sourcePath = $file->getRealPath();
            $image = null;

            if (in_array($extension, ['jpg', 'jpeg'])) {
                $image = imagecreatefromjpeg($sourcePath);
            } elseif ($extension == 'png') {
                $image = imagecreatefrompng($sourcePath);
            } elseif ($extension == 'webp') {
                $image = imagecreatefromwebp($sourcePath);
            } else {
                return response()->json(['error' => 'Geçersiz dosya.'], 422);
            }

            // 800px genişliğe indir
            $maxWidth = 800;
            $width = imagesx($image);
            $height = imagesy($image);
            if ($width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = floor($height * ($newWidth / $width));
                $resized = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
            }

            // WebP olarak kaydet, kaliteyi 50 başlat (ama 200KB'yı geçerse düşür)
            $fileName = Str::uuid() . '.webp';
            $fullPath = $targetPath . '/' . $fileName;
            $quality = 50;

            do {
                imagewebp($image, $fullPath, $quality);
                clearstatcache(true, $fullPath);
                $fileSizeKB = filesize($fullPath) / 1024;
                $quality -= 5;
            } while ($fileSizeKB > 200 && $quality > 10); // 200KB altına inene kadar

            imagedestroy($image);

            return response()->json(['fileName' => 'uploads/ideas/' . $fileName]);
        }

        return response()->json(['error' => 'Dosya bulunamadı.'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        // Fikri bul - sadece confirmed olanları göster VEYA kendi fikri ise göster
        $idea = Idea::active()->where('slug', $slug)
            ->where(function ($query) {
                $query->where('is_confirmed', 1);
                // Eğer giriş yapmışsa kendi onaylanmamış fikrini de görebilsin
                if (auth()->check()) {
                    $query->orWhere('user_id', auth()->id());
                }
            })
            ->firstOrFail();

        $lastIdeas = Idea::active()->confirmed()->where('slug', '!=', $slug)->orderByDesc('id')->limit(10)->get();


        if (request()->sort_by && request()->sort_by == 'like') {
            $replies = IdeaReply::where('idea_id', $idea->id)
                ->whereNull('parent_reply_id') // Sadece ana yorumlar
                ->withCount('likes') // Ana yorumların beğenilerini dahil et
                ->with('answers.likes', 'quotedReply') // Alt yorumların beğenilerini ve alıntıları dahil et
                ->get();

            $replies->each(function ($reply) {
                // Alt yorumların toplam beğeni sayısını hesapla
                $totalLikes = $reply->likes_count; // Ana yorumun beğeni sayısını al

                // Alt yorumların beğenilerini ekle
                $reply->answers->each(function ($answer) use (&$totalLikes) {
                    $totalLikes += $answer->likes->count(); // Alt yorumun beğeni sayısını ekle
                });

                // Alıntıların beğenilerini ekle
                if ($reply->quotedReply) {
                    $totalLikes += $reply->quotedReply->likes_count; // Alıntı beğeni sayısını ekle
                }

                // Toplam beğeni sayısını 'total_likes' olarak set et
                $reply->total_likes = $totalLikes;
            });

            // Beğeni sayısına göre sıralama
            $replies = $replies->sortByDesc('total_likes');
        } else {
            // Yorumları alıyoruz.
            $replies = IdeaReply::where('idea_id', $idea->id)->whereNull('parent_reply_id') // Sadece ana yorumları çek
                ->with(['answers', 'quotedReply'])->orderByDesc('id')->get(); // Alt yorumları ve alıntıları dahil et
        }

        // En çok beğeni alan yorumu alıyoruz.
        $mostLikedReply = IdeaReply::where('idea_id', $idea->id)->withCount('likes')
            ->having('likes_count', '>', 0)->orderByDesc('likes_count')->first();


        \App\Models\View::firstOrCreate(['ip' => get_user_ip_address(), 'to_id' => $idea->id, 'type' => 'idea']);

        return view('site.idea.show', compact('idea', 'lastIdeas', 'replies', 'mostLikedReply'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // reply ve like tablolarına foreign key eklenecek.
        $idea = Idea::whereId($id)->where('user_id', auth()->user()->id)->firstOrFail();
        return view('site.idea.edit', compact('idea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, string $id)
    {
        $idea = Idea::whereId($id)->where('user_id', auth()->user()->id)->firstOrFail();

        // Dosyalar varsa taşıyoruz.
        $path = [];
        // Kalan yükleme hakkını hesaplamak için yüklenmiş olan toplam dosya sayısından, şuan var olan dosya sayısını çıkarıyoruz.
        $count = count(json_decode($idea->path, true)) - count(explode(',', $request->old_uploaded_files)) ?? 0;

        //        if ($request->path && !empty($request->path) && count(json_decode($idea->path ?? '', true) ?? []) != 5) {
        // En fazla 4 dosya yüklenebileceği için ilk sadece ilk 4 dosyada işlem yapıyoruz.
        // Önceden yüklenen dosyaların sayısını 4'ten çıkarıp kalan sayı kadar dosya işlemi yapıyoruz
        for ($i = 0; $i < 4 - $count; $i++) {
            //                if ($request->hasFile('path.' . $i)) {
            //                    // Dosyayı ve yüklenilecek adını tutuyoruz.
            //                    $file = $request->file('path')[$i];
            //                    $fileName = time() . '_' . $file->getClientOriginalName();
            //
            //                    // Resimse kalitesini düşürüyoruz. Videoysa direkt taşıyoruz.
            //                    if (Str::startsWith($file->getMimeType(), 'image/')) {
            //                        $image = Image::read($file->getPathname()); // Intervention\Image\Image instance'ı
            //
            //                        $image->toWebp(70) // Kalite %70 oranında düşürülüyor
            //                        ->save('site/images/ideas/' . $fileName); // Resmi kaydediyoruz.
            //
            //                    } elseif (str()->startsWith($file->getMimeType(), 'video/')) {
            //                        $file->move('site/images/ideas', $fileName);
            //                    }
            //
            //                    // Dosyanın yolunu tutuyoruz.
            //                    $path[] = 'site/images/ideas/' . $fileName;
            $photo = explode(',', $request->uploaded_files)[$i] ?? null;
            if ($photo) $path[] = $photo;

            //                }
        }
        //        }


        // Alt kategori varsa, üst kategorinin alt kategorisi mi kontrol ediyoruz.
        if ($request->category_id && $request->sub_category_id) {
            $categoryExists = Category::select('id')->whereId($request->sub_category_id)->where('parent_id', $request->category_id)
                ->where('status', 1)->first();

            if (!$categoryExists) {
                return redirect()->back()->withError('Kategori bulunamadı.');
            }
        }

        if ($request->old_uploaded_files) {
            // Güncellemeden önce yüklenmiş olan ek dosyalar varsa yeni dosyalar ile beraber saklıyoruz
            foreach (explode(',', $request->old_uploaded_files) as $file) {
                if ($file) $path[] = $file;
            }
        }

        // Veriyi oluşturuyoruz.
        Idea::whereId($id)->where('user_id', auth()->user()->id)->update([
            'slug' => str()->slug(str()->limit($request->post('content'), 30, '')) . '-' . $idea->id,
            'content' => $request->post('content'),
            // 'cover_photo' => isset($coverFileName) ? $coverFileName : $idea->cover_photo,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'path' => !empty($path) ? json_encode($path) : null,
            'status' => $request->status
        ]);

        // Cache'i temizle
        CacheHelper::clearIdeaCache();

        return redirect()->route('idea.profile.index')->withSuccess('İşlem tamamlandı.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $userId = auth()->user()->id;
        Idea::whereId($id)->where('user_id', $userId)->delete();

        // Cache'i temizle
        CacheHelper::clearIdeaCache();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Fikir başarıyla silindi.',
                'stats' => $this->getUserIdeaStats($userId)
            ]);
        }

        return redirect()->route('idea.profile.index')->withSuccess('İşlem tamamlandı.');
    }

    private function getUserIdeaStats(int $userId): array
    {
        $baseQuery = Idea::where('user_id', $userId);

        return [
            'total' => (clone $baseQuery)->count(),
            'published' => (clone $baseQuery)->where('status', 1)->where('is_confirmed', 1)->count(),
            'active' => (clone $baseQuery)->where('status', 1)->count(),
            'pending' => (clone $baseQuery)->where('is_confirmed', 0)->count(),
            'passive' => (clone $baseQuery)->where('status', 0)->count(),
        ];
    }

    private function buildUserIdeasQuery(Request $request, int $userId)
    {
        $query = Idea::where('user_id', $userId);

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('content', 'like', '%' . $searchTerm . '%')
                  ->orWhere('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', ltrim($searchTerm, '#'));
            });
        }

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

        $sortBy = $request->sort_by;
        $sortOrder = $request->sort_order && in_array($request->sort_order, ['asc', 'desc']) ? $request->sort_order : 'desc';

        $query->withCount([
            'views as view_count' => function ($q) {
                $q->where('type', 'idea');
            },
            'likes as like_count',
            'replies as reply_count'
        ])->with(['category', 'subCategory']);

        if ($sortBy && in_array($sortBy, ['id', 'view_count', 'like_count', 'reply_count', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderByDesc('id');
        }

        return $query;
    }

    public function profileIndex(Request $request)
    {
        $userId = auth()->user()->id;
        $perPage = $request->per_page && in_array((int) $request->per_page, [10, 20, 50, 100]) ? (int) $request->per_page : 20;

        $ideas = $this->buildUserIdeasQuery($request, $userId)
            ->paginate($perPage)
            ->withQueryString();

        $ideaStats = $this->getUserIdeaStats($userId);

        return view('site.idea.profile-index', compact('ideas', 'ideaStats'));
    }

    public function profileSearch(Request $request)
    {
        $userId = auth()->user()->id;
        $perPage = $request->per_page && in_array((int) $request->per_page, [10, 20, 50, 100]) ? (int) $request->per_page : 20;

        $ideas = $this->buildUserIdeasQuery($request, $userId)
            ->paginate($perPage);
        $ideas->withPath(route('idea.profile.index'));

        $ideaStats = $this->getUserIdeaStats($userId);

        return response()->json([
            'success' => true,
            'html' => view('site.idea.partials.ideas-table', compact('ideas'))->render(),
            'pagination' => $ideas->links()->render(),
            'total' => $ideas->total(),
            'stats' => $ideaStats
        ]);
    }

    public function status(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $idea = Idea::whereId($id)->where('user_id', $userId)->firstOrFail();

        // Fikrin durumunu aktifse pasif, pasifse aktif yapıyoruz.
        $idea->status = $idea->status ? 0 : 1;
        $idea->save();

        // Cache'i temizle
        CacheHelper::clearIdeaCache();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'new_status' => (int) $idea->status,
                'is_confirmed' => (int) $idea->is_confirmed,
                'message' => $idea->status ? 'Fikir aktif edildi.' : 'Fikir pasife alındı.',
                'stats' => $this->getUserIdeaStats($userId)
            ]);
        }

        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }

    /****************************** YORUM İŞLEMLERİ ******************************/

    public function replyStore(Request $request)
    {

        $request->validate([
            'content' => ['required', 'string', 'max:3000'],
            'idea_id' => ['required', 'integer', 'exists:ideas,id'],
            'parent_reply_id' => ['nullable', 'integer', 'exists:idea_replies,id'],
            'quoted_reply_id' => ['nullable', 'integer', 'exists:idea_replies,id'],
        ]);

        $reply = IdeaReply::create([
            'content' => $request->content,
            'idea_id' => $request->idea_id,
            'user_id' => auth()->user()->id,
            'parent_reply_id' => $request->parent_reply_id, // Ana yorum mu, yoksa bir yanıta mı cevap?
            'quoted_reply_id' => $request->quoted_reply_id, // Alıntı yapıldıysa
            'status' => 1,
        ]);

        if ($request->quoted_reply_id) {
            // Bir yoruma cevap verildiyse, yorumun sahibine bildirim gönderiliyor.
            $this->notification(type: 'idea-reply-quoted', values: ['reply_id' => $reply->id, 'quoted_user_id' => $reply->quotedReply->user_id]);

            // Mail gönder - alıntı yapılan yorum sahibine
            $this->triggerEmailTemplate('idea-reply-quoted', $reply->quotedReply->user, [
                'replier_name' => auth_info()->name,
                'idea_title' => $reply->idea->title,
                'idea_link' => route('idea.show', $reply->idea->slug),
            ]);
        } else {
            // Normal yorumsa, fikrin sahibinde bildirim yolluyoruz.
            $this->notification('idea-reply', $reply->idea->user_id, ['slug' => $reply->idea->slug]);

            // Mail gönder - fikir sahibine
            $this->triggerEmailTemplate('idea-reply', $reply->idea->user, [
                'replier_name' => auth_info()->name,
                'idea_title' => $reply->idea->title,
                'idea_link' => route('idea.show', $reply->idea->slug),
            ]);
        }
        return redirect()->back()->withSuccess('Yanıt başarıyla eklendi!');
    }


    public function replyLike($id)
    {
        if (auth()->check()) {
            // Beğeni varsa kaldırıyoruz, yoksa ekleyip kullanıcıya gönderiyoruz.
            $like = IdeaReplyLike::where('user_id', auth()->user()->id)->where('reply_id', $id)->first();

            if ($like) {
                $like->delete();
                return response()->json(['status' => 'remove']);
            } else {
                IdeaReplyLike::create(['user_id' => auth()->user()->id, 'reply_id' => $id]);

                $this->notification(type: 'idea-like', values: ['idea_id' => $id]);

                // Mail gönder - beğenilen yorumun sahibine
                $likedReply = IdeaReply::find($id);
                if ($likedReply && $likedReply->user) {
                    $this->triggerEmailTemplate('idea-like', $likedReply->user, [
                        'liker_name' => auth_info()->name,
                        'idea_title' => $likedReply->idea->title ?? '',
                        'idea_link' => route('idea.show', $likedReply->idea->slug ?? ''),
                    ]);
                }

                return response()->json(['status' => 'add']);
            }
        }

        return response()->json(['status' => null]);
    }


    public function replyDestroy($id)
    {
        $reply = IdeaReply::findOrFail($id);

        // Yorumu silmeye çalışan kişi yorum sahibi veya fikir sahibiyse yorumu ve beğenileri siliyoruz.

        if ($reply->user_id == auth()->user()->id || $reply->idea->user_id == auth()->user()->id) {
            $reply->delete();
            $likes = IdeaReply::where('parent_reply_id', $id)->orWhere('quoted_reply_id', $id)->get();
            IdeaReply::where('parent_reply_id', $id)->orWhere('quoted_reply_id', $id)->delete();
            IdeaReplyLike::where('reply_id', $id)->delete();
            IdeaReplyLike::whereIn('reply_id', $likes->pluck('id')->toArray())->delete();
        }

        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }


    public function ideaLike($slug)
    {
        // fikrin varlığını kontrol ediyoruz - sadece confirmed olanları beğenilebilir
        $idea = Idea::active()->confirmed()->where('slug', $slug)->firstOrFail();

        // Beğeni var mı kontrol ediyoruz. Varsa siliyoruz, yoksa ekliyoruz.
        $like = IdeaLike::where('user_id', auth()->user()->id)->where('idea_id', $idea->id)->first();

        if ($like) {
            $like->delete();
            $isDeleted = 1;
        } else {
            IdeaLike::create(['user_id' => auth()->user()->id, 'idea_id' => $idea->id]);
            $isDeleted = 0;
        }

        return response()->json(['isDeleted' => $isDeleted]);
    }

    /************************ ADMIN İŞLEMLERİ ************************/
    public function adminIndex($status = null)
    {
        $ideas = Idea::query();

        if (request()->sub_category) {
            $ideas = $ideas->where('sub_category_id', request()->sub_category);
        }

        if ($status) {
            if (!in_array($status, ['active', 'passive'])) abort(404);

            $status = $status == 'passive' ? 0 : 1;
            $ideas = $ideas->where('status', $status);
        }

        $ideaCount = $ideas->count();
        $ideas = $ideas->orderByDesc('id')->paginate(20)->withQueryString();

        $subCategories = Category::whereNotNull('parent_id')->where('status', 1)->get();
        return view('admin.idea.index', compact('ideas', 'ideaCount', 'subCategories'));
    }


    public function adminComments($id)
    {
        $comments = IdeaReply::where('idea_id', $id)->orderByDesc('id')->paginate(20);
        return view('admin.idea.comments', compact('comments'));
    }


    public function adminCommentsDestroy($id)
    {
        IdeaReply::whereId($id)->delete();
        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }


    public function adminStatus($id)
    {
        // Fikrin aktif-pasif değerlerini güncelliyoruz.
        $idea = Idea::findOrFail($id);
        $idea->status = !$idea->status;
        $idea->save();

        return redirect()->back()->withSuccess('İşlem tamamlandı');
    }


    public function adminDestroy($id)
    {
        // NOT: idea_replies ve idea_reply_likes tabloları için foreign key eklenecek.
        Idea::whereId($id)->delete();
        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }

    /**
     * Fikri onayla
     */
    public function adminConfirm($id)
    {
        $idea = Idea::with('user')->findOrFail($id);
        $idea->is_confirmed = 1;
        $idea->save();

        // Fikir sahibine onay maili ve bildirimi gönder
        if ($idea->user) {
            // Email gönder
            $this->triggerEmailTemplate('idea-approved', $idea->user, [
                'idea_content' => \Str::limit($idea->content, 100),
                'idea_link' => route('idea.show', $idea->slug),
                'user_name' => $idea->user->informations->name ?? $idea->user->name ?? 'Kullanıcı',
            ]);

            // Bildirim gönder
            $this->notification('idea-approved', $idea->user_id, [
                'idea_link' => route('idea.show', $idea->slug),
            ]);
        }

        return redirect()->back()->withSuccess('Fikir onaylandı.');
    }

    /**
     * Fikir onayını kaldır
     */
    public function adminUnconfirm($id)
    {
        $idea = Idea::findOrFail($id);
        $idea->is_confirmed = 0;
        $idea->save();

        return redirect()->back()->withSuccess('Fikir onayı kaldırıldı.');
    }
}
