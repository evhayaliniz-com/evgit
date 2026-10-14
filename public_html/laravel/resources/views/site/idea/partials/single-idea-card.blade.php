<div class="modern-idea-card">
    {{-- Görsel Alanı & Yüzen Rozetler --}}
    <div class="mic-image-area">
        <a href="{{route('idea.show', $idea->slug)}}" class="mic-image-link" tabindex="-1">
            <img src="{{asset(json_decode($idea->path)[0] ?? 'site/images/no-image.png')}}"
                 alt="{{$idea->title}}"
                 loading="lazy"
                 class="mic-image">
            <div class="mic-image-overlay"></div>
        </a>

        {{-- Kategori Rozeti (Sol Üst) --}}
        @if($idea?->category?->name)
            <span class="mic-badge-category" title="{{$idea->category->name}}">
                <i class="fa-solid fa-lightbulb"></i> {{$idea->category->name}}
            </span>
        @endif

        {{-- Beğeni / Kalp Butonu (Sağ Üst) --}}
        @php
            $isLiked = $idea->ideaLikeExists($idea->id);
            $totalLikes = $idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id);
        @endphp
        <button type="button"
                class="mic-like-btn {{ $isLiked ? 'is-liked' : '' }}"
                @auth() onclick="ideaLike('{{$idea->slug}}')" @endauth
                @guest() onclick="showLoginPopup('Beğenmek için giriş yapmalısınız!', this)" @endguest
                title="{{ $isLiked ? 'Beğenildi' : 'Beğen' }}">
            <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
        </button>
    </div>

    {{-- İçerik Alanı --}}
    <div class="mic-body">
        {{-- Fikir Başlığı --}}
        <h3 class="mic-title">
            <a href="{{route('idea.show', $idea->slug)}}" title="{{$idea->title}}">
                {{$idea->title}}
            </a>
        </h3>

        {{-- Açıklama Metni --}}
        <p class="mic-desc" title="{{$idea->content}}">
            {{ Str::limit(strip_tags($idea->content), 95) }}
        </p>

        {{-- Açıklama Altında: Paylaşım Yapan Kullanıcı ve Görüntülenme Alanı --}}
        <div class="mic-author-row">
            @php
                $user = auth_info($idea->user_id);
                $ideaUserModel = \App\Models\User::find($idea->user_id);
                $avatar = $user && $user->avatar ? $user->avatar : 'site/images/default_avatar.jpg';
                $name = $user && $user->name ? $user->name : 'Anonim';
                $isCompany = $ideaUserModel && $ideaUserModel->user_type === 'company' && $ideaUserModel->company;
            @endphp

            @if($isCompany)
                <a href="{{ route('companies.show', $ideaUserModel->company->slug) }}" class="mic-author-link" title="{{ $name }}">
                    <div class="mic-author-avatar">
                        <img src="{{ asset($avatar) }}" alt="{{ $name }}" loading="lazy">
                    </div>
                    <span class="mic-author-name">{{ $name }}</span>
                    <span class="mic-verified-badge" title="Onaylı Firma">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                </a>
            @else
                <div class="mic-author-link">
                    <div class="mic-author-avatar">
                        <img src="{{ asset($avatar) }}" alt="{{ $name }}" loading="lazy">
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
                        @auth() onclick="ideaLike('{{$idea->slug}}')" @endauth
                        @guest() onclick="showLoginPopup('Beğenmek için giriş yapmalısınız!', this)" @endguest
                        title="{{ $isLiked ? 'Beğenildi' : 'Beğen' }}">
                    <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                    <span>{{ $totalLikes }}</span>
                </button>
                <a href="{{route('idea.show', $idea->slug)}}?comment=show" class="mic-action-btn-item mic-btn-comment" title="Yorumlar">
                    <i class="fa-regular fa-comment-dots"></i>
                    <span>{{ $idea->replies->count() }}</span>
                </a>
                <button type="button"
                        class="mic-action-btn-item mic-btn-share"
                        onclick="navigator.clipboard.writeText('{{route('idea.show', $idea->slug)}}'); if(typeof toastr !== 'undefined') { toastr.success('Bağlantı kopyalandı!'); }"
                        title="Bağlantıyı Kopyala">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
            </div>

            <a href="{{route('idea.show', $idea->slug)}}" class="mic-btn-explore" title="Fikri İncele">
                <span>İncele</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
