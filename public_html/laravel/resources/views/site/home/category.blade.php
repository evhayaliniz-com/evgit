<div class="category-slider">
    <div class="swiper mySwiper2">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                <div class="swiper-slide category-slide">
                    <a href="{{ route('services.index') }}?category={{ $category->id }}" class="modern-category-card" title="{{ $category->name }}">
                        <img
                            src="{{ asset($category->image) }}"
                            alt="{{ $category->name }}"
                            loading="lazy"
                            decoding="async"
                            class="mcc-image"
                        >
                        <div class="mcc-overlay"></div>
                        <div class="mcc-content">
                            <span class="mcc-title">{{ $category->name }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-prev category-slider-nav category-slider-prev" aria-label="Önceki kategoriler"></div>
        <div class="swiper-button-next category-slider-nav category-slider-next" aria-label="Sonraki kategoriler"></div>
    </div>
</div>


