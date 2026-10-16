@php
    $sliders = \Illuminate\Support\Facades\Cache::remember('active_sliders_list', 1800, function () {
        return \App\Models\Slider::where('status', 1)->orderByDesc('order')->get();
    });
@endphp

@if($sliders->isNotEmpty())
<div class="main-slider">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                @php
                    $hasLink = !empty($slider->button_link) && trim($slider->button_link) !== '#';
                @endphp
                <div class="swiper-slide">
                    @if($hasLink)
                        <a href="{{ $slider->button_link }}" target="_blank" rel="noopener noreferrer" class="main-slider-item is-clickable">
                    @else
                        <div class="main-slider-item">
                    @endif
                            <img
                                src="{{ asset($slider->image) }}"
                                alt="{{ $slider->title ?? 'Evhayaliniz' }}"
                                @if($loop->first)
                                    fetchpriority="high"
                                @else
                                    fetchpriority="low"
                                    loading="lazy"
                                @endif
                            >
                            <div class="main-slider-overlay"></div>
                            @if($slider->title || $slider->description)
                                <div class="main-slider-texts">
                                    @if($slider->title)
                                        <h1 class="text-white">{{ $slider->title }}</h1>
                                    @endif
                                    @if($slider->description)
                                        <p>{!! nl2br(e($slider->description)) !!}</p>
                                    @endif
                                </div>
                            @endif
                    @if($hasLink)
                        </a>
                    @else
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if($sliders->count() > 1)
            <div class="swiper-button-prev main-slider-nav main-slider-prev" aria-label="Önceki slayt"></div>
            <div class="swiper-button-next main-slider-nav main-slider-next" aria-label="Sonraki slayt"></div>
            <div class="swiper-pagination"></div>
        @endif
    </div>
</div>
@endif

