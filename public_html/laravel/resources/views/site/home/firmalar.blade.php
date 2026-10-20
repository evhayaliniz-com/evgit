<div class="popular-services one-cikan-firmalar">
    <div class="cs-title d-flex cs-title-link">
        <div class="ctl-left">
            <i class="fa-solid fa-building"></i>
            <h2> Öne Çıkan Firmalar </h2>
        </div>
        <div class="ctl-right">
            <a href="{{route('companies.index')}}" class="cs-all-link"> Tüm Firmalar <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="popular-slider one-cikan-firmalar-slider">
        <div class="swiper mySwiper5">
            <div class="swiper-wrapper">
                @foreach($companies as $company)
                    <div class="swiper-slide">
                        @include('site.company.partials.single-company-card', ['company' => $company])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev popular-slider-nav firmalar-slider-prev" aria-label="Önceki firmalar"></div>
            <div class="swiper-button-next popular-slider-nav firmalar-slider-next" aria-label="Sonraki firmalar"></div>
        </div>
    </div>
</div>
