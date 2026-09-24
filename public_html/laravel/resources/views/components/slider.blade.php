@php
    $sliders = \App\Models\Slider::where('status', 1)->orderByDesc('order')->get();
@endphp

<style>
/* Slider tıklama sorununu çöz */
.main-slider a {
    position: relative !important;
    z-index: 10 !important;
    pointer-events: auto !important;
    display: block !important;
    width: 100% !important;
    height: 100% !important;
}

.main-slider .swiper-slide {
    position: relative !important;
    z-index: 1 !important;
}



</style>

<div class="main-slider">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="main-slider">
                        <a href="{{$slider->button_link ?? '#'}}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                        </a>
                        <div class="main-slider-texts">
                            <a href="{{$slider->button_link ?? '#'}}" target="_blank" rel="noopener noreferrer">
                                @if($slider->title)
                                    <h1 class="text-white">{{ $slider->title }}</h1>
                                @endif
                                @if($slider->description)
                                    <p>{!! nl2br(e($slider->description)) !!}</p>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
