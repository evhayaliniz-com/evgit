@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="tum-hizmetler">
                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-slider tum-hizmetler-top"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>
                            Hizmetlerim
                        </h5>

                        <div class="form-group d-flex gap-3" style="position:relative; top: 20px">
                            <a href="{{route('company.services.create')}}"
                               class="btn text-white"
                               style="background-color: #4068e2; border-color: #4068e2; height: 37px;">
                                Oluştur
                            </a>

                            <form action="" method="GET">
                                <select name="status" class="form-select" onchange="this.closest('form').submit()">
                                    <option value="">Tümü</option>
                                    <option value="aktif" @selected(request()->status == 'aktif')>Aktif</option>
                                    <option value="pasif" @selected(request()->status == 'pasif')>Pasif</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-inner">
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-md-6 col-lg-4 col-xl-3" style="">
                                    <div class="popular-services-cards">
                                        <div class="psc-img position-relative">
                                            <a href="{{route('services.show', $service->slug)}}">
                                                <img src="{{asset($service->photos->first()['path'] ?? null)}}"
                                                     alt="{{$service->title}}">
                                            </a>

                                            <div class="fpedit-decor">
                                                <div class="firma-profil-edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    Düzenle
                                                </div>
                                                <div class="firma-profil-edit-box bg-white">
                                                    <div class="d-flex">
                                                        <a href="{{route('company.services.edit', $service->id)}}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                            Düzenle
                                                        </a>
                                                    </div>

                                                    <div class="d-flex">
                                                        <a href="{{route('company.services.status', $service->id)}}">
                                                            <i class="fa-solid fa-eye"></i>
                                                            {{$service->status ? 'Pasif Yap' : 'Aktif Yap'}}
                                                        </a>
                                                    </div>

                                                    <div class="d-flex remove">
                                                        <form action="{{ route('company.services.destroy', $service->id) }}"
                                                              method="POST" class="d-inline"
                                                              onsubmit="return ">
                                                            @csrf

                                                            @method('DELETE')
                                                            <a href="javascript:void(0)"
                                                               onclick="if(confirm('Bu servisi silmek istediğinize emin misiniz?'))
                                                                                           this.closest('form').submit()">
                                                                <i class="fa-solid fa-trash"></i>
                                                                Sil
                                                            </a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="psd-texts">
                                            <h3>
                                                <a href="{{route('services.show', $service->slug)}}">{{$service->title}}</a>
                                            </h3>
                                            <div class="psd-texts-icons">
                                                <div class="pti-area">
                                                    <i class="fa-solid fa-tag"></i>
                                                    <span>
                                                        {{$service?->category?->name
                                                        . ' / ' . $service?->subCategory?->name}}
                                                    </span>
                                                </div>
                                                <div class="pti-area">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <span>
                                                        {{$service->province->name . ' / ' . $service?->district?->name}}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="firma-goruntulenme d-flex mt-2">
                                                           <span style="font-size: 13px!important;">
                                                              Görüntülenme
                                                           </span>
                                                <b>
                                                    {{ number_format($service->serviceViewCount($service->id), 0, ',', '.') }}
                                                </b>
                                            </div>

                                            <div class="psd-prices">
                                                <div class="psd-prices-left">
                                                    <x-old-prices :prices="$service->oldPrices" />

                                                    <span>
                                                         {{ number_format($service->price, 0, ',', '.') }} TL
                                                    </span>
                                                </div>

                                                <div class="psd-prices-right text-white {{$service->status ? 'bg-success' : 'bg-danger'}}">
    <span>
        <i class="fas {{$service->status ? 'fa-check-circle' : 'fa-times-circle'}} me-1"></i>
        {{$service->status ? 'Aktif' : 'Pasif'}}
    </span>
                                                </div>
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
