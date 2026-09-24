<div class="main-slider">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="main-slider">
                        <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                        <div class="main-slider-texts">
                            @if($slider->title)
                                <h1>{{ $slider->title }}</h1>
                            @endif
                            @if($slider->description)
                                <p>{!! nl2br(e($slider->description)) !!}</p>
                            @endif
                            @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" class="btn btn-primary mt-2">{{ $slider->button_text }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
