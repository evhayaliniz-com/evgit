<div class="popular-services">
    <div class="cs-title d-flex cs-title-link">
        <div class="ctl-left">
            <i class="fa-solid fa-comment"></i>
            <h2> Fikir Köşesi </h2>
        </div>
        <div class="ctl-right">
            <a href="{{route('idea.index')}}" class="cs-all-link"> Tüm Fikirler
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="popular-slider fikir-kosesi">
        <div class="swiper mySwiper4">
            <div class="swiper-wrapper">
                @foreach($ideas as $idea)
                    <div class="swiper-slide">
                        @include('site.idea.partials.single-idea-card', ['idea' => $idea])
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
