<div class="popular-services">
    <div class="cs-title d-flex cs-title-link">
        <div class="ctl-left">
            <i class="fa-solid fa-business-time"></i>
            <h2> Popüler Hizmetler </h2>
        </div>
        <div class="ctl-right">
            <a href="{{route('services.index')}}"> Tüm Hizmetler
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="popular-slider">
        <div class="swiper mySwiper3">
            <div class="swiper-wrapper">
                @foreach($services as $service)
                    <div class="swiper-slide">
                        <div class="popular-services-cards">
                            <div class="psc-img">
                                <a href="{{route('services.show', $service->slug)}}">
                                    <img src="{{asset($service->photos->first()['path'] ?? null)}}"
                                         alt="{{$service->title}}">
                                </a>
                            </div>
                            <div class="psd-texts">
                                <h3>
                                    <a href="{{route('services.show', $service->slug)}}">{{$service->title}}</a>
                                </h3>
                                <div class="psd-texts-icons">
                                    <div class="pti-area">
                                        <i class="fa-solid fa-tag"></i>
                                        <span> {{$service?->category?->name . ' / ' . $service?->subCategory?->name}} </span>

                                    </div>
                                    <div class="pti-area">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>
                                                        {{$service->province->name . ' / ' . $service->district->name}}
                                                    </span>
                                    </div>
                                </div>
                                {{--                                                <p class="mb-0">{{str()->limit($service->description, 100)}}</p>--}}
                                <div class="psd-firma">
                                    <a href="{{route('companies.show', $service->company->slug)}}" class=" d-flex gap-2">
                                        <img src="{{asset($service->company->avatar)}}"
                                             alt="{{$service->company->name}}"
                                             style="width: 20px; height: 20px; border-radius: 50%">
                                        <span>
                                        {{$service->company->name}}
                                    </span>
                                    </a>
                                </div>

                                <div class="psd-prices">
                                    <div class="psd-prices-left">
                                        <x-old-prices :prices="$service->oldPrices" />
                                        
                                        <span>
                                             {{ number_format($service->price, 0, ',', '.') }} TL
                                         </span>
                                    </div>

                                    <div class="psd-prices-right">
                                        {{ $service->payment_type == 'card' ? 'Kart' : 'Nakit' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>