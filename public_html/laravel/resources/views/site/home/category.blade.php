<div class="category-slider">
    <div class="cs-title d-flex mb-2">
        <i class="fa-solid fa-table-cells-large"></i>
        <h2> Kategoriler </h2>
    </div>

    <div class="swiper mySwiper2">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                <div class="swiper-slide" style="display: inline-block; width: auto; padding: 0; margin: 0; font-size: 0;">
                    <div class="category-slider-box" style="display: inline-block; padding: 0; margin: 0;">
                        <a href="{{route('services.index')}}?category={{$category->id}}" style="display: block; text-decoration: none;">
                            <div class="csb-img" style="
                                    display: block;
                                    width: 120px;
                                    height: 90px;
                                    margin: 0;
                                    padding: 0;
                                    overflow: hidden;
                                    line-height: 0;
                                ">
                                                <img style="
                                        display: block;
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                        margin: 0;
                                        padding: 0;
                                    " src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                            </div>
                            <div class="csb-text" style="display: block; margin: 0; padding: 0;">
                                <p style="font-size: 14px; font-weight: 400; color:#445568; margin: 0; padding: 5px 0 0 0;">
                                    {{ $category->name }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
