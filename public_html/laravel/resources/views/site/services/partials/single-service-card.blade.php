@php
    $firstPhoto = $service->photos?->first()['path'] ?? 'site/images/no-image.png';
    $photoCount = $service->photos ? $service->photos->count() : 0;
@endphp
<div class="modern-service-card">
    {{-- Görsel Alanı & Yüzen Rozetler --}}
    <div class="msc-image-area">
        <a href="{{ route('services.show', $service->slug) }}" class="msc-image-link" tabindex="-1">
            <img src="{{ asset($firstPhoto) }}"
                 alt="{{ $service->title }}"
                 loading="lazy"
                 decoding="async"
                 class="msc-image">
            <div class="msc-image-overlay"></div>
        </a>

        {{-- Kategori Rozeti (Sol Üst) --}}
        @if($service?->category?->name)
            <span class="msc-badge-category" title="{{ $service->category->name }}">
                {{ $service->category->name }}
            </span>
        @endif

        {{-- Favori / Kaydet Butonu (Sağ Üst) --}}
        @auth
            @php
                $isSaved = $service->relationLoaded('savedServices')
                    ? $service->savedServices->contains('user_id', auth()->id())
                    : \App\Models\ServiceSaved::where('user_id', auth()->id())->where('service_id', $service->id)->exists();
            @endphp
            <a href="{{ route('services.save', $service->slug) }}"
               class="msc-bookmark-btn {{ $isSaved ? 'is-saved' : '' }}"
               aria-label="{{ $isSaved ? 'Kaydedildi' : 'Favorilere Ekle' }}"
               title="{{ $isSaved ? 'Kaydedildi' : 'Favorilere Ekle' }}">
                <i class="{{ $isSaved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
            </a>
        @else
            <button type="button"
                    class="msc-bookmark-btn"
                    onclick="showLoginPopup('Kaydetmek için giriş yapmalısınız!', this)"
                    aria-label="Favorilere Ekle"
                    title="Favorilere Ekle">
                <i class="fa-regular fa-bookmark"></i>
            </button>
        @endauth

        {{-- Alt Kategori Rozeti (Sol Alt) --}}
        @if($service?->subCategory?->name)
            <span class="msc-badge-subcategory" title="{{ $service->subCategory->name }}">
                {{ $service->subCategory->name }}
            </span>
        @endif

        {{-- Çoklu Fotoğraf Sayacı (Sağ Alt) --}}
        @if($photoCount > 1)
            <span class="msc-photo-count" title="{{ $photoCount }} Fotoğraf">
                <i class="fa-regular fa-images"></i> {{ $photoCount }}
            </span>
        @endif
    </div>

    {{-- İçerik Alanı --}}
    <div class="msc-body">
        {{-- Hizmet Başlığı --}}
        <h3 class="msc-title">
            <a href="{{ route('services.show', $service->slug) }}" title="{{ $service->title }}">
                {{ $service->title }}
            </a>
        </h3>

        {{-- Başlık Altında: Firma Adı ve Konum Bilgisi Aynı Satırda --}}
        <div class="msc-firm-location-row">
            @if($service->company)
                <a href="{{ route('companies.show', $service->company->slug) }}" class="msc-company-link" title="{{ $service->company->name }}">
                    <div class="msc-company-avatar">
                        <img src="{{ asset(!empty($service->company->avatar) ? $service->company->avatar : 'site/images/default-avatar.png') }}"
                             alt="{{ $service->company->name }}"
                             loading="lazy"
                             decoding="async">
                    </div>
                    <span class="msc-company-name">{{ $service->company->name }}</span>
                    <span class="msc-verified-badge" title="Onaylı Firma">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                </a>
            @endif

            @if($service->province?->name || $service->district?->name)
                <div class="msc-location" title="{{ $service->province?->name }}{{ $service->district?->name ? ' / ' . $service->district?->name : '' }}">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ $service->province?->name . ($service->district?->name ? ' / ' . $service->district?->name : '') }}</span>
                </div>
            @endif
        </div>

        {{-- Alt Kısım: Fiyat & Aksiyon Butonu --}}
        <div class="msc-footer">
            <div class="msc-price-wrapper">
                <div class="msc-price-row">
                    <div class="psd-prices-left msc-old-price-box">
                        <x-old-prices :prices="$service->oldPrices" />
                    </div>
                    <span class="msc-current-price">
                        {{ number_format($service->price, 0, ',', '.') }} <small>TL</small>
                    </span>
                </div>
            </div>

            <a href="{{ route('services.show', $service->slug) }}" class="msc-action-btn" title="Hizmeti İncele">
                <span>İncele</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
