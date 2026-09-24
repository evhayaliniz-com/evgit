@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="tum-hizmetler">
                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-slider tum-hizmetler-top"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>Kaydedilen Hizmetler</h5>
                    </div>
                </div>

                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-inner">
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-md-6 col-lg-4 col-xl-3">
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
                                                    <span> {{$service?->category?->name . ' > ' . $service?->subCategory?->name}} </span>
                                                </div>
                                                <div class="pti-area">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <span> {{$service->province->name . ' / ' . $service->district->name}} </span>
                                                </div>
                                            </div>
                                            <div class="psd-firma">
                                                <p class="mb-0">{{str()->limit($service->description, 100)}}</p>
                                            </div>
                                            <div class="psd-prices">
                                                <div class="psd-prices-left">
                                                    <x-old-prices :prices="$service->oldPrices" />

                                                    <span>
                                                     {{ number_format($service->price, 0, ',', '.') }} TL
                                                 </span>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end gap-3">
                                                <a href="{{auth()->user()->user_type == 'user' ? route('user.saved-services.destroy', $service->id)
                                                   : route('company.saved-services.destroy', $service->id) }}"
                                                   class="btn btn-danger text-white">Kaldır</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{$services->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
