@php
    $companyAvatar = !empty($company->avatar) ? $company->avatar : 'site/images/default-avatar.png';
    $bannerImage = !empty($company?->category?->image) ? asset($company->category->image) : null;
    $approvedRatings = $company->ratings ? $company->ratings->where('is_approved', true) : collect();
    $ratingSource = $approvedRatings->isNotEmpty() ? $approvedRatings : ($company->ratings ?? collect());
    $averageRating = $ratingSource->avg('rating') ?? 0;
    $ratingCount = $ratingSource->count();
    $phone = $company->mobile_phone ?: $company->fixed_phone;
    $locationText = ($company->provinceInfo->name ?? 'Türkiye') . ($company->districtInfo ? ' / ' . $company->districtInfo->name : '');
@endphp
<div class="modern-company-card">
    {{-- Üst Kapak / Banner Alanı & Yüzen Cam Rozetler --}}
    <div class="mcc-banner" @if($bannerImage) style="--mcc-banner-img: url('{{ $bannerImage }}');" @endif>
        <div class="mcc-banner-bg"></div>
        <div class="mcc-banner-overlay"></div>

        <div class="mcc-banner-badges">
            @if($company?->category?->name)
                <span class="mcc-badge-category" title="{{ $company->category->name }}">
                    {{ $company->category->name }}
                </span>
            @endif

            @if($company->is_verified == 1)
                <span class="mcc-badge-verified" title="Doğrulanmış ve Onaylı Firma">
                    <i class="fa-solid fa-shield-check fa-circle-check"></i> Onaylı
                </span>
            @endif
        </div>
    </div>

    {{-- Avatar & Değerlendirme Puanı Satırı --}}
    <div class="mcc-header-row">
        <a href="{{ route('companies.show', $company->slug) }}" class="mcc-avatar-link" tabindex="-1">
            <img src="{{ asset($companyAvatar) }}"
                 alt="{{ $company->name }}"
                 loading="lazy"
                 decoding="async"
                 class="mcc-avatar">
        </a>

        <div class="mcc-rating-pill {{ $ratingCount == 0 ? 'is-new' : '' }}"
             title="{{ $ratingCount > 0 ? number_format($averageRating, 1) . ' Puan (' . $ratingCount . ' Değerlendirme)' : 'Yeni Katılan Firma' }}">
            <i class="fa-solid fa-star"></i>
            <span class="mcc-rating-score">{{ $ratingCount > 0 ? number_format($averageRating, 1) : 'Yeni' }}</span>
            @if($ratingCount > 0)
                <span class="mcc-rating-count">({{ $ratingCount }})</span>
            @endif
        </div>
    </div>

    {{-- İçerik Gövdesi --}}
    <div class="mcc-body">
        {{-- Firma Adı --}}
        <h3 class="mcc-title">
            <a href="{{ route('companies.show', $company->slug) }}" title="{{ $company->name }}">
                {{ $company->name }}
            </a>
            @if($company->is_verified == 1)
                <span class="mcc-verified-check" title="Onaylı Firma">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
            @endif
        </h3>

        {{-- Kısa Açıklama --}}
        <p class="mcc-desc" title="{{ strip_tags($company->about) }}">
            {{ !empty($company->about) ? Str::limit(strip_tags($company->about), 88) : 'Müşteri memnuniyetini ön planda tutarak profesyonel ve güvenilir hizmet sunmaktadır.' }}
        </p>

        {{-- Hizmet & Fikir Kartlarıyla Uyumlu Bilgi Kutusu: Alt Kategori & Konum --}}
        <div class="mcc-meta">
            <span class="mcc-subcat-badge" title="{{ $company?->subCategory?->name ?? $company?->category?->name ?? 'Kurumsal Hizmet' }}">
                <i class="fa-solid fa-tag"></i>
                <span>{{ $company?->subCategory?->name ?? $company?->category?->name ?? 'Kurumsal' }}</span>
            </span>

            <div class="mcc-location" title="{{ $locationText }}">
                <i class="fa-solid fa-location-dot"></i>
                <span>{{ $locationText }}</span>
            </div>
        </div>

        {{-- Alt Kısım: Aksiyon Butonları (Hizmet & Fikir Kartlarıyla Birebir Uyumlu Footer) --}}
        <div class="mcc-footer">
            <div class="mcc-actions-left">
                @if($phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                       class="mcc-btn-call"
                       title="Hemen Ara: {{ $phone }}"
                       onclick="event.stopPropagation();">
                        <i class="fa-solid fa-phone"></i>
                        <span>Hemen Ara</span>
                    </a>
                @else
                    <a href="{{ route('companies.show', $company->slug) }}" class="mcc-btn-call is-profile-meta" title="Firma Profili">
                        <i class="fa-regular fa-building"></i>
                        <span>Kurumsal</span>
                    </a>
                @endif
            </div>

            <a href="{{ route('companies.show', $company->slug) }}"
               class="mcc-btn-explore"
               title="{{ $company->name }} Profilini İncele">
                <span>İncele</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
