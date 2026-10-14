<div class="category-slider">
    <div class="cs-title d-flex" style="margin-bottom: 16px;">
        <i class="fa-solid fa-table-cells-large"></i>
        <h2>Kategoriler</h2>
    </div>

    <div class="swiper mySwiper2">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                <div class="swiper-slide category-slide">
                    <a href="{{route('services.index')}}?category={{$category->id}}" class="modern-category-card">
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" loading="lazy" class="mcc-image">
                        <div class="mcc-overlay"></div>
                        <div class="mcc-content">
                            <span class="mcc-title">{{ $category->name }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

