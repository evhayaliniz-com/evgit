<div class="modern-company-card">
    {{-- Üst Banner & Rozetler --}}
    <div class="mcc-banner">
        <div class="mcc-banner-bg"></div>
        <div class="mcc-banner-badges">
            @if($company?->category?->name)
                <span class="mcc-badge-category" title="{{ $company->category->name }}">
                    <i class="fa-solid fa-layer-group"></i> {{ $company->category->name }}
                </span>
            @endif

            @if($company->is_verified == 1)
                <span class="mcc-badge-verified" title="Doğrulanmış ve Onaylı Firma">
                    <i class="fa-solid fa-circle-check"></i> Onaylı
                </span>
            @endif
        </div>
    </div>

    {{-- Avatar & Puan Satırı --}}
    <div class="mcc-header-row">
        <a href="{{ route('companies.show', $company->slug) }}" class="mcc-avatar-link" tabindex="-1">
            <img src="{{ asset($company->avatar ?? 'site/images/default_avatar.jpg') }}"
                 alt="{{ $company->name }}"
                 loading="lazy"
                 class="mcc-avatar">
        </a>

        @php
            $averageRating = $company->ratings->avg('rating') ?? 0;
            $ratingCount = $company->ratings->count();
        @endphp
        <div class="mcc-rating-pill {{ $ratingCount == 0 ? 'is-new' : '' }}"
             title="{{ $ratingCount > 0 ? number_format($averageRating, 1) . ' Puan (' . $ratingCount . ' Değerlendirme)' : 'Henüz Değerlendirme Yok' }}">
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

        {{-- Alt Kategori & Konum --}}
        <div class="mcc-meta">
            @if($company?->subCategory?->name)
                <span class="mcc-subcat-badge" title="{{ $company->subCategory->name }}">
                    <i class="fa-solid fa-tag"></i> {{ $company->subCategory->name }}
                </span>
            @endif

            <div class="mcc-location" title="{{ ($company->provinceInfo->name ?? '') . ($company->districtInfo ? ' / ' . $company->districtInfo->name : '') }}">
                <i class="fa-solid fa-location-dot"></i>
                <span>{{ ($company->provinceInfo->name ?? 'Türkiye') . ($company->districtInfo ? ' / ' . $company->districtInfo->name : '') }}</span>
            </div>
        </div>

        {{-- Kısa Açıklama --}}
        <p class="mcc-desc" title="{{ $company->about }}">
            {{ !empty($company->about) ? Str::limit(strip_tags($company->about), 85) : 'Müşteri memnuniyetini ön planda tutarak profesyonel ve güvenilir hizmet sunmaktadır.' }}
        </p>

        {{-- Alt Kısım: Aksiyon Butonları --}}
        <div class="mcc-footer">
            @php
                $phone = $company->mobile_phone ?: $company->fixed_phone;
            @endphp

            @if($phone)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"
                   class="mcc-btn-call"
                   title="Hemen Ara: {{ $phone }}"
                   onclick="event.stopPropagation();">
                    <i class="fa-solid fa-phone"></i>
                    <span>Ara</span>
                </a>
            @endif

            <a href="{{ route('companies.show', $company->slug) }}"
               class="mcc-btn-explore"
               title="{{ $company->name }} Profilini İncele">
                <span>Profili İncele</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
