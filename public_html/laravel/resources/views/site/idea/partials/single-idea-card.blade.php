@php
    $decodedPhotos = json_decode($idea->path, true);
    $photoList = is_array($decodedPhotos) ? $decodedPhotos : [];
    $firstIdeaPhoto = $photoList[0] ?? 'site/images/no-image.png';
    $ideaPhotoCount = count($photoList);
@endphp
<div class="modern-idea-card">
    {{-- Görsel Alanı & Yüzen Rozetler --}}
    <div class="mic-image-area">
        <a href="{{ route('idea.show', $idea->slug) }}" class="mic-image-link" tabindex="-1">
            <img src="{{ asset($firstIdeaPhoto) }}"
                 alt="{{ $idea->title }}"
                 loading="lazy"
                 decoding="async"
                 class="mic-image">
            <div class="mic-image-overlay"></div>
        </a>

        {{-- Kategori Rozeti (Sol Üst) --}}
        @if($idea?->category?->name)
            <span class="mic-badge-category" title="{{ $idea->category->name }}">
                {{ $idea->category->name }}
            </span>
        @endif

        {{-- Beğeni / Kalp Butonu (Sağ Üst) --}}
        @php
            $isLiked = $idea->ideaLikeExists($idea->id);
            $totalLikes = $idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id);
        @endphp
        <button type="button"
                class="mic-like-btn {{ $isLiked ? 'is-liked' : '' }}"
                @auth() onclick="ideaLike('{{ $idea->slug }}')" @endauth
                @guest() onclick="showLoginPopup('Beğenmek için giriş yapmalısınız!', this)" @endguest
                aria-label="{{ $isLiked ? 'Beğenildi' : 'Beğen' }}"
                title="{{ $isLiked ? 'Beğenildi' : 'Beğen' }}">
            <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
        </button>

        {{-- Alt Kategori Rozeti (Sol Alt) --}}
        @if($idea?->subCategory?->name)
            <span class="mic-badge-subcategory" title="{{ $idea->subCategory->name }}">
                {{ $idea->subCategory->name }}
            </span>
        @endif

        {{-- Çoklu Fotoğraf Sayacı (Sağ Alt) --}}
        @if($ideaPhotoCount > 1)
            <span class="mic-photo-count" title="{{ $ideaPhotoCount }} Fotoğraf">
                <i class="fa-regular fa-images"></i> {{ $ideaPhotoCount }}
            </span>
        @endif
    </div>

    {{-- İçerik Alanı --}}
    <div class="mic-body">
        {{-- Fikir Başlığı (Sadece Varsa Gösterilir) --}}
        @if(!empty(trim($idea->title ?? '')))
            <h3 class="mic-title">
                <a href="{{ route('idea.show', $idea->slug) }}" title="{{ $idea->title }}">
                    {{ $idea->title }}
                </a>
            </h3>
        @endif

        {{-- Açıklama Metni --}}
        <p class="mic-desc" title="{{ strip_tags($idea->content) }}">
            <a href="{{ route('idea.show', $idea->slug) }}" class="mic-desc-link">
                {{ Str::limit(strip_tags($idea->content), 95) }}
            </a>
        </p>

        {{-- Açıklama Altında: Paylaşım Yapan Kullanıcı ve Görüntülenme Alanı --}}
        <div class="mic-author-row">
            @php
                $user = auth_info($idea->user_id);
                $ideaUserModel = \App\Models\User::find($idea->user_id);
                $avatar = $user && !empty($user->avatar) ? $user->avatar : 'site/images/default-avatar.png';
                $name = $user && $user->name ? $user->name : 'Anonim';
                $isCompany = $ideaUserModel && $ideaUserModel->user_type === 'company' && $ideaUserModel->company;
            @endphp

            @if($isCompany)
                <a href="{{ route('companies.show', $ideaUserModel->company->slug) }}" class="mic-author-link" title="{{ $name }}">
                    <div class="mic-author-avatar">
                        <img src="{{ asset($avatar) }}" alt="{{ $name }}" loading="lazy" decoding="async">
                    </div>
                    <span class="mic-author-name">{{ $name }}</span>
                    <span class="mic-verified-badge" title="Onaylı Firma">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                </a>
            @else
                <div class="mic-author-link">
                    <div class="mic-author-avatar">
                        <img src="{{ asset($avatar) }}" alt="{{ $name }}" loading="lazy" decoding="async">
                    </div>
                    <span class="mic-author-name">{{ $name }}</span>
                </div>
            @endif

            <div class="mic-views" title="Görüntülenme">
                <i class="fa-regular fa-eye"></i>
                <span>{{ $idea->ideaViewCount($idea->id) }}</span>
            </div>
        </div>

        {{-- Alt Kısım: Aksiyon Butonları (Beğen, Yorum, Paylaş & İncele) --}}
        <div class="mic-footer">
            <div class="mic-actions-group">
                <button type="button"
                        class="mic-action-btn-item mic-btn-like {{ $isLiked ? 'is-liked' : '' }}"
                        @auth() onclick="ideaLike('{{ $idea->slug }}')" @endauth
                        @guest() onclick="showLoginPopup('Beğenmek için giriş yapmalısınız!', this)" @endguest
                        title="{{ $isLiked ? 'Beğenildi' : 'Beğen' }}">
                    <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                    <span>{{ $totalLikes }}</span>
                </button>
                <a href="{{ route('idea.show', $idea->slug) }}?comment=show" class="mic-action-btn-item mic-btn-comment" title="Yorumlar">
                    <i class="fa-regular fa-comment-dots"></i>
                    <span>{{ $idea->replies->count() }}</span>
                </a>
                <button type="button"
                        class="mic-action-btn-item mic-btn-share"
                        onclick="navigator.clipboard.writeText('{{ route('idea.show', $idea->slug) }}'); if(typeof toastr !== 'undefined') { toastr.success('Bağlantı kopyalandı!'); }"
                        aria-label="Bağlantıyı Kopyala"
                        title="Bağlantıyı Kopyala">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
            </div>

            <a href="{{ route('idea.show', $idea->slug) }}" class="mic-btn-explore" title="Fikri İncele">
                <span>İncele</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
