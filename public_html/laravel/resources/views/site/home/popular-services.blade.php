<div class="popular-services">
    <div class="cs-title d-flex cs-title-link">
        <div class="ctl-left">
            <i class="fa-solid fa-business-time"></i>
            <h2> Popüler Hizmetler </h2>
        </div>
        <div class="ctl-right">
            <a href="{{route('services.index')}}" class="cs-all-link"> Tüm Hizmetler
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="popular-slider popular-services-slider">
        <div class="swiper mySwiper3">
            <div class="swiper-wrapper">
                @foreach($services as $service)
                    <div class="swiper-slide">
                        @include('site.services.partials.single-service-card', ['service' => $service])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev popular-slider-nav popular-services-prev" aria-label="Önceki hizmetler"></div>
            <div class="swiper-button-next popular-slider-nav popular-services-next" aria-label="Sonraki hizmetler"></div>
        </div>
    </div>
</div>
