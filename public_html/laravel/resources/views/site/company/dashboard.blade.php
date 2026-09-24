@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right">
                <div class="firma-profil-box">
                    <div class="firma-profil-top">
                        <div class="success-firma-profil sfp-mobil">
                        <a @if(auth()->user()->company->is_verified == 0) 
                               data-bs-toggle="modal" data-bs-target="#onayliprofilol" 
                           @elseif(auth()->user()->company->is_verified == 1)
                               data-bs-toggle="modal" data-bs-target="#onayliprofildurum"
                           @endif>
                                <span class="text-dark">
                                    @if(auth()->user()->company->is_verified == 0)
                                        <img src="{{asset('site/images/success.png')}}" alt="">
                                        Onaylı Profil Ol

                                    @elseif(auth()->user()->company->is_verified == 1)
                                        <img src="{{asset('site/images/success.png')}}" alt="">
                                        Onaylı Profil

                                    @elseif(auth()->user()->company->is_verified == 2)
                                        Değerlendiriliyor
                                    @endif
                                 </span>
                            </a>
                        </div>
                    </div>
                    <div class="firma-profil-in">
                        <div class="firma-profil-logo">
                            <img src="{{asset(auth()->user()->company->avatar)}}" alt="Avatar" style=" object-fit: cover; border-radius: 8px;">
                        </div>
                        <div class="firma-profil-membership fpm-web">
                            <style>
                                .eplan-button {
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 6px;
                                    background-color: #fff;
                                    color: #007BFF;
                                    border: 2px solid #007BFF;
                                    padding: 8px 14px;
                                    border-radius: 6px;
                                    font-weight: 600;
                                    text-decoration: none;
                                    transition: all 0.3s ease;
                                }

                                .eplan-button:hover {
                                    background-color: #007BFF;
                                    color: #fff;
                                }
                            </style>
                            @php
                                use App\Models\ProPackageCategory;

                                $company = auth()->user()->company;
                                $hasEplanPreview = false;

                                if ($company) {
                                    $latestPackage = $company->latestActivePackage();
                                    if ($latestPackage) {
                                        $hasEplanPreview = ProPackageCategory::where('pro_package_id', $latestPackage->id)
                                            ->where('eplan_preview', 1)
                                            ->exists();
                                    }   
                                }
                            @endphp

                            @if($hasEplanPreview)
                                <div class=" fp-eplan">
                                    <a href="{{ route('company.eplan') }}" class="btn btn-outline-primary button-outline button">
                                        <i class="fa-solid fa-house-circle-check"></i>
                                        <span>E-Plan</span>
                                    </a>
                                </div>
                            @endif

                            <div class="fp-edit">
                                <a class="button button-mid" href="{{ route('company.profile.edit') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Profili Düzenle</span>
                                </a>
                            </div>

                            <div class="fp-edit fp-pro">
                                @if(auth()->user()->company->latestActivePackage())
                                    <a class="button-primary button" href="{{ route('company.subscriptions.index') }}">
                                        <i class="fa-solid fa-crown"></i>
                                        <span>Aboneliğim</span>
                                    </a>
                                @else
                                    <a class="button-primary button" href="{{ route('company.packages.index') }}">
                                        <i class="fa-solid fa-crown"></i>
                                        <span>Pro Üyelik</span>
                                    </a>
                                @endif
                            </div>




                        </div>

                        <div class="firma-profil-informations">
                            <div class="fpi-title d-flex">
                                <div>
                                    <h1>
                                        {{auth()->user()->company->name}}
                                    </h1>
                                </div>
                                <div class="success-firma-profil sfp-web">
                                    <a @if(auth()->user()->company->is_verified == 0)
                                           data-bs-toggle="modal" data-bs-target="#onayliprofilol"
                                       @elseif(auth()->user()->company->is_verified == 1)
                                           data-bs-toggle="modal" data-bs-target="#onayliprofildurum"
                                            @endif>
                                        <span>
                                            @if(auth()->user()->company->is_verified == 0)
                                                <img src="{{asset('site/images/success.png')}}" alt="">
                                                Onaylı Profil Ol

                                            @elseif(auth()->user()->company->is_verified == 1)
                                                <img src="{{asset('site/images/success.png')}}" alt="">
                                                Onaylı Profil

                                            @elseif(auth()->user()->company->is_verified == 2)
                                                Değerlendiriliyor
                                            @endif
                                       </span>
                                    </a>

                                </div>
                            </div>
                            <div class="fp-infos">
                            {{-- <div class="fp-infos-box">--}}
                            {{-- <i class="fa-solid fa-location-dot"></i>--}}
                            {{-- <span>--}}
                            {{-- Kayseri--}}
                            {{-- </span>--}}
                            {{-- </div>--}}
                            {{-- <div class="fp-infos-box">--}}
                            {{-- <i class="fa-solid fa-phone"></i>--}}
                            {{-- <span>--}}
                            {{-- 0555 555 55 55--}}
                            {{-- </span>--}}
                            {{-- </div>--}}
                            </div>
                        </div>
                        <div class="firma-profil-membership fpm-mobil">
                            @if($hasEplanPreview)
                                <div class="fp-eplan">
                                    <a href="{{ route('company.eplan') }}" class="btn btn-outline-primary button-outline button">
                                        <i class="fa-solid fa-house-circle-check"></i>
                                        <span>E-Plan</span>
                                    </a>
                                </div>
                            @endif
                            <div class="fp-edit">
                                <a class="button button-mid" href="{{route('company.profile.edit')}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>
                                   Profili Düzenle
                                    </span>
                                </a>
                            </div>
                            <div class="fp-edit fp-pro">
                                @if(auth()->user()->company->latestActivePackage())
                                    <a class="button-primary button" href="{{ route('company.subscriptions.index') }}">
                                        <i class="fa-solid fa-crown"></i>
                                        <span>Aboneliğim</span>
                                    </a>
                                @else
                                    <a class="button-primary button" href="{{route('company.packages.index')}}">
                                        <i class="fa-solid fa-crown"></i>
                                        <span>Pro Üyelik</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="firma-analiz bg-white">
                    <div class="firma-analiz-main-title">
                           <div>
                            <h3 style="font-size: 15px!important;">Analizler</h3>
                        </div>
                        <div class="firma-analiz-open-area">
                        <svg class="faoa-down" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                            <path fill="currentColor" d="m12 15.4l-6-6L7.4 8l4.6 4.6L16.6 8L18 9.4z" />
                        </svg>
                        <svg class="faoa-close" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                            <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z" />
                        </svg>
                        </div>
                    </div>
                    <div class="firma-analiz-title d-flex">
                        <div>
                       
                        </div>

                        @if(auth()->user()->company->purchasedPackages->isNotEmpty())
                                <div class="analiz-select d-flex gap-3 mb-3">
                        <select name="service" id="serviceFilter" class="form-select">
                                        <option value="">Tüm Hizmetler</option>
                                        @foreach($services as $service)
                            <option value="{{$service->id}}" @selected(request()->service == $service->id)>{{str()->limit($service->title, 50)}}</option>
                                        @endforeach
                                    </select>

                        <select name="day" id="dayFilter" class="form-select">
                                        <option value="1" @selected(request()->day == 1)>1 Gün</option>
                                        <option value="7" @selected(request()->day == 7)>7 Gün</option>
                                        <option value="30" @selected(request()->day == 30)>30 Gün</option>
                                        <option value="90" @selected(request()->day == 90)>90 Gün</option>
                                    </select>
                                </div>
                        @endif
                    </div>
                    <div class="analiz-inner">
                        <div class="analiz-flex d-flex">
                            <div class="analiz-left">
                                <div class="analiz-boxes box-green @if(auth()->user()->company->purchasedPackages
                                    ->isEmpty()) blur @endif">
                                    <div class="ab-title">
                                        Firma Profil Ziyareti
                                    </div>
                                    <div class="ab-inner">
                                    <b id="profileCurrentCount">{{$profileCurrentCount}}</b>
                                    <p id="profilePercentage">
                                            @if(analytic_percentage_change($profileOldCount, $profileCurrentCount) >= 0)
                                                <i class="fa-solid fa-up-long"></i>
                                                +{{analytic_percentage_change($profileOldCount, $profileCurrentCount)}}%

                                            @else
                                                <i class="fa-solid fa-down-long"></i>
                                                {{analytic_percentage_change($profileOldCount, $profileCurrentCount)}}%
                                            @endif

                                            önceki döneme göre
                                        </p>
                                    </div>
                                </div>
                                <div class="analiz-boxes box-red @if(auth()->user()->company->purchasedPackages
                                    ->isEmpty()) blur @endif">
                                    <div class="ab-title">
                                        Hizmetler Ziyareti
                                    </div>
                                    <div class="ab-inner">
                                    <b id="serviceCurrentCount">{{$serviceCurrentCount}}</b>
                                    <p id="servicePercentage">
                                            @if(analytic_percentage_change($serviceOldCount, $serviceCurrentCount) >= 0)
                                                <i class="fa-solid fa-up-long"></i>
                                                +{{analytic_percentage_change($serviceOldCount, $serviceCurrentCount)}}%

                                            @else
                                                <i class="fa-solid fa-down-long"></i>
                                                {{analytic_percentage_change($serviceOldCount, $serviceCurrentCount)}}%
                                            @endif
                                            önceki döneme göre
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->user()->company->purchasedPackages->isEmpty())
                                <div class="analiz-right">
                                    <p>
                                        Detaylı analiz ve daha fazla veri için
                                    </p>
                                    <a href="{{route('company.packages.index')}}">
                                        Pro Üye Ol
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <style>
                #myTab button {
                            font-size: 15px;
                        }
                        
                        .ab-title {
                            text-align: center !important;
                        }
                        
                        .ab-inner {
                            text-align: center !important;
                        }
                        
                        .ab-inner b {
                            display: block;
                            text-align: center;
                        }
                        
                        .ab-inner p {
                            text-align: center;
                            font-size: 15px !important;
                }

                .analiz-boxes.loading {
                    opacity: 0.7;
                    transition: opacity 0.3s ease;
                }

                        .analiz-select select:disabled {
                            opacity: 0.6;
                            cursor: not-allowed;
                        }
                        
                        /* KEŞİN ÇÖZÜM - Ana CSS'i override et */
                        .tum-hizmetler-box.index-right .dashboard-header-flex.d-flex.align-items-center.justify-content-between {
                            display: flex !important;
                            flex-direction: row !important;
                            flex-wrap: nowrap !important;
                            justify-content: space-between !important;
                            align-items: center !important;
                            margin-top: 0 !important;
                            width: 100% !important;
                            gap: 10px !important;
                            padding-top: 15px !important;
                        }
                        
                        .tum-hizmetler-box.index-right .dashboard-header-flex .dashboard-title {
                            flex: 1 !important;
                            margin-right: 10px !important;
                            white-space: nowrap !important;
                            overflow: hidden !important;
                            text-overflow: ellipsis !important;
                            margin-bottom: 0 !important;
                        }
                        
                        .tum-hizmetler-box.index-right .dashboard-header-flex form {
                            flex-shrink: 0 !important;
                            margin: 0 !important;
                        }
                        
                        .tum-hizmetler-box.index-right .dashboard-header-flex .form-select {
                            width: 180px !important;
                            min-width: 180px !important;
                            font-size: 14px !important;
                        }
                        
                        /* Tüm Bootstrap override'ları */
                        .dashboard-header-flex.d-flex.justify-content-between.align-items-center {
                            flex-direction: row !important;
                            flex-wrap: nowrap !important;
                        }
                        
                        /* Fiyat input wrapper CSS */
                        .price-input-wrapper {
                            position: relative;
                            display: flex;
                            align-items: center;
                            margin: 10px 0;
                        }
                        
                        .price-input-wrapper .price-input {
                            border: 1px solid #cdcccf !important;
                            text-align: center;
                            border-radius: 8px;
                            padding-right: 35px !important;
                            margin: 0 !important;
                        }
                        
                        .price-input-wrapper .price-suffix {
                            position: absolute;
                            right: 10px;
                            color: #666;
                            font-size: 14px;
                            pointer-events: none;
                        }
                        
                        /* Hizmet arama ve filtre elementleri için responsive CSS */
                        .hizmetler-title-right.justify-content-end {
                            margin-left: auto !important;
                            width: auto !important;
                            max-width: 100% !important;
                        }
                        
                        .hizmetler-title-right .d-flex.gap-2 {
                            flex-wrap: wrap !important;
                            justify-content: flex-end !important;
                        }
                        
                        @media (max-width: 991.98px) {
                            .hizmetler-title-right.justify-content-end {
                                justify-content: center !important;
                                margin-left: 0 !important;
                                width: 100% !important;
                            }
                            
                            .hizmetler-title-right .d-flex.gap-2 {
                                justify-content: center !important;
                                gap: 0.5rem !important;
                            }
                        }
                        
                        @media (max-width: 767.98px) {
                            .hizmetler-title-right .d-flex.gap-2 {
                                flex-direction: column !important;
                                align-items: stretch !important;
                                gap: 0.5rem !important;
                            }
                            
                            .hizmetler-title-right .form-select {
                                width: 100% !important;
                                min-width: unset !important;
                            }
                            
                            .hizmetler-title-right-search {
                                width: 100% !important;
                            }
                        }
                        
                        /* İşlem butonlarını çok küçült - dikey dizilim ve ortalama */
                        .tumhizmetler-islemlerbox {
                            padding: 2px 4px !important;
                            margin: 1px auto !important;
                            min-height: 20px !important;
                            max-height: 22px !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            width: 22px !important;
                            min-width: 22px !important;
                            max-width: 22px !important;
                            border-radius: 3px !important;
                            overflow: visible !important;
                            box-sizing: border-box !important;
                        }
                        
                        .tumhizmetler-islemlerbox a {
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            width: 100% !important;
                            height: 100% !important;
                            overflow: hidden !important;
                        }
                        
                        /* İçerik taşmasını önle ama tooltip'i göster */
                        .tumhizmetler-islemlerbox form {
                            overflow: hidden !important;
                        }
                        
                        .tumhizmetler-islemlerbox i {
                            font-size: 10px !important;
                        }
                        
                        .tumhizmetler-islemler {
                            display: flex !important;
                            flex-direction: column !important;
                            gap: 1px !important;
                            align-items: center !important;
                            justify-content: center !important;
                        }
                        
                        /* İşlemler kolonunu 50px ile sınırla */
                        .tumhizmetlernewtable.table-responsive thead th:last-child,
                        .tumhizmetlernewtable.table-responsive td:last-child {
                            width: 50px !important;
                            max-width: 50px !important;
                            min-width: 50px !important;
                            padding: 4px 2px !important;
                            text-align: center !important;
                            vertical-align: middle !important;
                            position: relative !important;
                        }
                        
                        /* İşlemler td'sinin içeriğini tam ortala */
                        .tumhizmetlernewtable.table-responsive td:last-child {
                            display: table-cell !important;
                            text-align: center !important;
                            vertical-align: middle !important;
                        }
                        
                        /* İşlemler kolonu header'ı da küçült */
                        .tumhizmetlernewtable.table-responsive thead th:last-child {
                            font-size: 12px !important;
                            padding: 8px 2px !important;
                        }
                        
                        /* İşlemler container'ını da sınırla - dikey dizilim ve ortalama */
                        .tumhizmetler-islemler {
                            width: 100% !important;
                            max-width: 50px !important;
                            height: auto !important;
                            display: flex !important;
                            flex-direction: column !important;
                            align-items: center !important;
                            justify-content: center !important;
                            gap: 1px !important;
                            margin: 0 auto !important;
                        }
                        
                        /* Mobil responsive kuralları */
                        @media (max-width: 767.98px) {
                            .tum-hizmetler-box.index-right .dashboard-header-flex .dashboard-title {
                                font-size: 14px !important;
                            }
                            
                            .tum-hizmetler-box.index-right .dashboard-header-flex .form-select {
                                width: 140px !important;
                                min-width: 140px !important;
                                font-size: 13px !important;
                            }
                        }
                        
                        @media (max-width: 575.98px) {
                            .tum-hizmetler-box.index-right .dashboard-header-flex .dashboard-title {
                                font-size: 13px !important;
                            }
                            
                            .tum-hizmetler-box.index-right .dashboard-header-flex .form-select {
                                width: 120px !important;
                                min-width: 120px !important;
                                font-size: 12px !important;
                            }
                        }
                </style>
                <div class="firma-tabs-area">
                    <div class="firma-tabs-box">
                        <ul class="nav nav-tabs firma-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home"
                                        type="button" role="tab" aria-controls="home" aria-selected="true">Hizmetler
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                        type="button" role="tab" aria-controls="profile" aria-selected="false">Sorular
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                                    Değerlendirmeler
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="takipci-tab" data-bs-toggle="tab" data-bs-target="#takipci"
                                        type="button" role="tab" aria-controls="takipci" aria-selected="false">Takipçi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="takipedilen-tab" data-bs-toggle="tab"
                                        data-bs-target="#takipedilen" type="button" role="tab"
                                        aria-controls="takipedilen"
                                        aria-selected="false">Takip Edilen
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content mb-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="tum-hizmetler">
                                <div style="background: #fff !important;" class="tum-hizmetler-box index-right ms-0 ps-2 ps-lg-4">
                                    <div class="tum-hizmetler-inner">

                                        <div class="d-flex justify-content-between mb-3 align-items-center dashboard-header-flex">
                                                <h5 class="dashboard-title mb-0">Hizmetler ({{$serviceCount}})</h5>

                                                <form action="" method="GET">
                                                    <select name="order_by" class="form-select"
                                                    onchange="this.closest('form').submit()">
                                                        <option value="">Standart Sıralama</option>
                                                        <option value="price_asc" @selected(request()->order_by == 'price_asc')>
                                                            Fiyata Göre (Artan)
                                                        </option>
                                                        <option value="price_desc" @selected(request()->order_by == 'price_desc')>
                                                            Fiyata Göre (Azalan)
                                                        </option>
                                                        <option value="date_desc" @selected(request()->order_by == 'date_desc')>
                                                            Tarihe Göre (Yeniden Eskiye)
                                                        </option>
                                                        <option value="date_asc" @selected(request()->order_by == 'date_asc')>
                                                            Tarihe Göre (Eskiden Yeniye)
                                                        </option>
                                                    </select>
                                                </form>
                                            </div>

                                            <div class="row ps-1 ps-md-0">
                                                @foreach($services as $service)
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="popular-services-cards">
                                                            <div class="psc-img">
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
                                                                        <span> {{$service?->category?->name . ' / ' . $service?->subCategory?->name}} </span>

                                                                    </div>
                                                                    <div class="pti-area">
                                                                        <i class="fa-solid fa-location-dot"></i>
                                                                        <span>
                                                        {{$service->province->name . ' / ' . $service->district->name}}
                                                    </span>
                                                                    </div>
                                                                </div>
                                                        {{-- <p class="mb-0">{{str()->limit($service->description, 100)}}</p>--}}


                                                        <div class="firma-goruntulenme d-flex mt-2">
                                                            <span style="font-size: 13px!important;">
                                                                Görüntülenme
                                                            </span>
                                                            <b>
                                                                {{$service->view_count ?? 0}}
                                                            </b>
                                                        </div>
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

                                            {{$services->appends(request()->query())->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="tab-bg">
                                    <div class="d-flex">
                                        @foreach($questions as $question)
                                            <div class="sorular-box w-50">
                                                <div class="sorular-title d-flex">
                                                    <div class="sorular-title-left">
                                                        <img src="{{asset(auth_info($question->user_id)->avatar)}}"
                                                             class="profile-avatar-min"
                                                             alt="{{auth_info($question->user_id)->name}}">
                                                        <span>
                                                            {{auth_info($question->user_id)->name}}
                                                        </span>
                                                    </div>
                                                    <form action="{{route('services.question.destroy', [$question->service->slug, $question->id])}}"
                                                          method="POST"
                                                          onsubmit="return confirm('Bu soruyu silmek istediğinize emin misiniz?');">
                                                        @method('DELETE')

                                                        @csrf
                                                        <div class="sorular-title-right">
                                                            <button type="submit">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="sorular-text">
                                                    <p>
                                                        {{$question->question}}
                                                    </p>
                                                </div>
                                                <div class="sorular-time">
                                                     <span>
                                                        {{change_timezone($question->created_at, 'H:i')}}
                                                     </span>
                                                    <span>
                                                        {{change_timezone($question->created_at, 'd.m.Y')}}
                                                     </span>
                                                </div>

                                                @if($question->answer)
                                                    <div class="question-answer-box">
                                                        <div class="sorular-text">
                                                            <b>Cevap:</b>
                                                            <p>
                                                                {{$question->answer}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif


                                                <form action="{{route('services.answer', $question->service->slug)}}"
                                                      method="POST">
                                                    <div class="sorular-input">
                                                        <div class="text-area-head d-flex">
                                                            <img src="{{asset(auth_info()->avatar)}}"
                                                                 alt="{{auth_info()->name}}">
                                                            <b>{{auth_info()->name}}</b>
                                                        </div>

                                                        <input name="question" type="hidden"
                                                               value="{{\Illuminate\Support\Facades\Crypt::encryptString($question->id)}}">

                                                        <textarea name="answer" rows="4" cols="50"
                                                    placeholder="Cevap ver..." required>{{old('answer', $question->answer)}}</textarea>
                                                    </div>

                                                    @csrf
                                                    <div class="sorular-cevap">
                                                        <button type="submit">{{!$question->answer ? 'Cevapla' : 'Cevabı Güncelle'}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>

                                {{$questions->appends(request()->query())->links()}}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="tab-bg">
                                    <div class="degerlendirmeler">
                                        <div class="degerlendirme-box">
                                            <h3 class="degerlendirme-title">
                                                Firma Değerlendirme
                                            </h3>
                                            <div class="degerlendirme-inner">
                                                <div class="d-flex">
                                                    <div class="stars-box">
                                                        @for($i = 1; $i <= 5; $i++)
                                                        @if($i <=floor($averageRating))
                                                                <i class="fa-solid fa-star"></i>
                                                            @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                                                <i class="fa-solid fa-star-half-stroke"></i>
                                                            @else
                                                                <i class="fa-regular fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <div class="degerlendirme-score">
                                                        <b>
                                                            {{number_format($averageRating, 1)}}/5
                                                        </b>
                                                        <p class="mb-0">
                                                            {{$totalRatings}} değerlendirme
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        @forelse($ratings as $rating)
                                        <div class="degerlendirme-box">
                                            <div class="sorular-title d-flex degerlendirme-title2">
                                                <div class="sorular-title-left">
                                                    <img src="{{asset(auth_info($rating->user_id)->avatar)}}" alt="{{auth_info($rating->user_id)->name}}">
                                                    <span>
                                                        {{auth_info($rating->user_id)->name}}
                                                    </span>
                                                </div>
                                                <div class="sorular-title-right">
                                                    <span class="degerlendirme-date">
                                                        {{$rating->created_at->format('d.m.Y')}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="degerlendirme-inner">
                                                <div class="d-flex">
                                                    <div class="stars-box">
                                                        @for($i = 1; $i <= 5; $i++)
                                                        @if($i <=$rating->rating)
                                                                <i class="fa-solid fa-star"></i>
                                                            @else
                                                                <i class="fa-regular fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <div class="degerlendirme-score">
                                                        <b>
                                                            {{$rating->rating}}/5
                                                        </b>
                                                    </div>
                                                </div>
                                                @if($rating->comment)
                                                <div class="degerlendirme-bottom">
                                                    <p>
                                                        {{$rating->comment}}
                                                    </p>
                                                    @if($rating->service && $rating->service->cover_photo)
                                                    <div>
                                                        <img src="{{asset($rating->service->cover_photo)}}" alt="{{$rating->service->title}}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                    </div>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @empty
                                        <div class="degerlendirme-box">
                                            <div class="text-center py-4">
                                                <p class="mb-0">Henüz değerlendirme bulunmamaktadır.</p>
                                            </div>
                                        </div>
                                        @endforelse

                                    </div>
                                    
                                    @if($ratings->hasPages())
                                    <div class="pagination degerlendirme-pagination">
                                    {{$ratings->appends(request()->query())->links()}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="takipci" role="tabpanel" aria-labelledby="takipci-tab">
                                <div class="tab-bg">
                                    <div class="takipci-head">
                                        <div class="takipci-input">
                                            <form action="" method="GET">
                                                <input name="follower_name" type="text" placeholder="Takipçi Ara"
                                                       value="{{request()->follower_name}}">
                                                <i class="fa-solid fa-magnifying-glass"
                                                   onclick="this.closest('form').submit()"></i>
                                            </form>
                                        </div>
                                        <div class="takipci-count">
                                          <span>
                                             Takipçiler ({{$followersCount}})
                                          </span>
                                        </div>
                                    </div>
                                    <div class="takipci-body">
                                        @foreach($followers as $follower)
                                            <div class="takipci-box">
                                                <div class="sorular-title d-flex takipci-title">
                                                    <div class="sorular-title-left">
                                                        <img src="{{asset(auth_info($follower->user_id)->avatar)}}"
                                                             alt="{{auth_info($follower->user_id)->name}}"
                                                             style="width: 60px; height: 60px">
                                                        <span>
                                                            {{auth_info($follower->user_id)->name}}
                                                        </span>
                                                    </div>
                                                    <div class="sorular-title-right">
                                               <div class="takipci-links">
                                                    <ul>
                                                        <li>
                                                            <a class="button-primary button" href="{{route('chat.show', $follower->user_id)}}">
                                                                Mesaj
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{route('company.follow')}}" method="POST">
                                                                <a class="button button-mid" href="#" onclick="this.closest('form').submit()">
                                                                    Takipten Çık
                                                                </a>

                                                                <input type="hidden" name="status" value="2">

                                                                <input type="hidden" name="user"
                                                                       value="{{\Illuminate\Support\Facades\Crypt::encryptString($follower->user_id)}}">
                                                                @csrf
                                                            </form>
                                                        </li>
                                                        {{-- <li>--}}
                                                        {{-- <a href="#">--}}
                                                        {{-- Profili Gör >--}}
                                                        {{-- </a>--}}
                                                        {{-- </li>--}}
                                                    </ul>
                                                </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                {{$followers->appends(request()->query())->links()}}
                                </div>
                            </div>

                            <div class="tab-pane fade" id="takipedilen" role="tabpanel"
                                 aria-labelledby="takipedilen-tab">
                                <div class="tab-bg">
                                    <div class="takipci-head">
                                        <div class="takipci-input">
                                            <form action="" method="GET">
                                                <input name="following_name" type="text" placeholder="Takip Edilen Ara"
                                                       value="{{request()->following_name}}">
                                                <i class="fa-solid fa-magnifying-glass"
                                                   onclick="this.closest('form').submit()"></i>
                                            </form>
                                        </div>
                                        <div class="takipci-count">
                                          <span>
                                             Takip Edilen ({{$followingsCount}})
                                          </span>
                                        </div>
                                    </div>
                                    <div class="takipci-body">
                                        @foreach($followings as $following)
                                            <div class="takipci-box">
                                                <div class="sorular-title d-flex takipci-title">
                                                    <div class="sorular-title-left">
                                                        <img src="{{asset(auth_info($following->to_id)->avatar)}}"
                                                             alt="{{auth_info($following->to_id)->name}}"
                                                             style="width: 60px; height: 60px">
                                                        <span>
                                                            {{auth_info($following->to_id)->name}}
                                                        </span>
                                                    </div>
                                                    <div class="sorular-title-right">
       <div class="takipci-links">
                                                    <ul>
                                                        <li>
                                                            <a class="button-primary button" href="{{route('chat.show', $following->to_id)}}">
                                                                Mesaj
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{route('company.follow')}}" method="POST">
                                                                <a class="button button-mid" href="#" onclick="this.closest('form').submit()">
                                                                    Takipten Çık
                                                                </a>

                                                                <input type="hidden" name="user"
                                                                       value="{{\Illuminate\Support\Facades\Crypt::encryptString($following->to_id)}}">
                                                                @csrf
                                                            </form>
                                                        </li>
                                                        {{-- <li>--}}
                                                        {{-- <a href="#">--}}
                                                        {{-- Profili Gör >--}}
                                                        {{-- </a>--}}
                                                        {{-- </li>--}}
                                                    </ul>
                                                </div>
                                                    </div>
                                                </div>
                                         
                                            </div>
                                        @endforeach
                                    </div>

                                {{$followings->appends(request()->query())->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('site.home.footer')
            </div>



        </div>


    </div>



    <div class="modal fade login-modal" id="onayliprofilol" tabindex="-1" aria-labelledby="onayliprofilolLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="onayliprofilolLabel">Onaylı Profil Ol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="firma-sikayeti-box">
                        <p>
                            Uzmanlarımız Vergi bilgileriniz ve Konum adresinizi doğrulamak için size ulaşacak.
                        </p>
                        <div class="login-button">
                            <a href="{{route('company.send-verify')}}">
                                <button type="button">Başvur</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Onaylı Profil Durum Modalı -->
<div class="modal fade login-modal" id="onayliprofildurum" tabindex="-1" aria-labelledby="onayliprofildurumlabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="onayliprofildurumlabel">Onaylı Profil Durumu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="firma-sikayeti-box">
                    <div class="text-center mb-3">
                        <img src="{{asset('site/images/success.png')}}" alt="Onaylı" style="width: 60px; height: 60px;">
                    </div>
                    <h6 class="text-center mb-3">Tebrikler! Onaylı Profilsiniz</h6>
                    <p class="text-center">
                        @if(auth()->user()->company->getVerificationDate())
                            {{auth()->user()->company->getVerificationDate()->format('d.m.Y')}} tarihinden itibaren onaylı profilsiniz.
                        @else
                            Onaylı profilsiniz.
                        @endif
                        <br><br>
                        Onaylı profil olarak müşterilerinize daha güvenilir görünüyor ve daha fazla iş fırsatına erişim sağlıyorsunuz.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
    /**
     * AJAX Dashboard Analytics Filter Implementation
     * 
     * This script handles the dynamic updating of analytics data on the company dashboard
     * without requiring a page refresh. It listens for changes to the service and day filters
     * and makes AJAX requests to update the analytics display in real-time.
     * 
     * Features:
     * - Real-time analytics updates without page refresh
     * - Loading indicators during AJAX requests
     * - Error handling with user feedback
     * - URL state management (updates browser URL)
     * - Responsive UI with disabled states during loading
     */
    document.addEventListener('DOMContentLoaded', function() {
        const serviceFilter = document.getElementById('serviceFilter');
        const dayFilter = document.getElementById('dayFilter');

        if (serviceFilter && dayFilter) {
            function updateAnalytics() {
                const service = serviceFilter.value;
                const day = dayFilter.value;

                // Show loading state
                const profileCount = document.getElementById('profileCurrentCount');
                const serviceCount = document.getElementById('serviceCurrentCount');
                const profilePercentage = document.getElementById('profilePercentage');
                const servicePercentage = document.getElementById('servicePercentage');

                // Disable filters during loading
                serviceFilter.disabled = true;
                dayFilter.disabled = true;

                // Add loading class to boxes
                const profileBox = profileCount?.closest('.analiz-boxes');
                const serviceBox = serviceCount?.closest('.analiz-boxes');
                if (profileBox) profileBox.classList.add('loading');
                if (serviceBox) serviceBox.classList.add('loading');

                if (profileCount) profileCount.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                if (serviceCount) serviceCount.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

                // Make AJAX request
                fetch(`{{ route('company.dashboard.analytics') }}?service=${service}&day=${day}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update profile count
                        if (profileCount) {
                            profileCount.textContent = data.profileCurrentCount;
                        }

                        // Update service count
                        if (serviceCount) {
                            serviceCount.textContent = data.serviceCurrentCount;
                        }

                        // Update profile percentage
                        if (profilePercentage) {
                            const profileChange = data.profilePercentageChange;
                            let profileIcon = '';
                            let profileText = '';

                            if (profileChange >= 0) {
                                profileIcon = '<i class="fa-solid fa-up-long"></i>';
                                profileText = `+${profileChange}%`;
                            } else {
                                profileIcon = '<i class="fa-solid fa-down-long"></i>';
                                profileText = `${profileChange}%`;
                            }

                            profilePercentage.innerHTML = `${profileIcon} ${profileText} önceki döneme göre`;
                        }

                        // Update service percentage
                        if (servicePercentage) {
                            const serviceChange = data.servicePercentageChange;
                            let serviceIcon = '';
                            let serviceText = '';

                            if (serviceChange >= 0) {
                                serviceIcon = '<i class="fa-solid fa-up-long"></i>';
                                serviceText = `+${serviceChange}%`;
                            } else {
                                serviceIcon = '<i class="fa-solid fa-down-long"></i>';
                                serviceText = `${serviceChange}%`;
                            }

                            servicePercentage.innerHTML = `${serviceIcon} ${serviceText} önceki döneme göre`;
                        }

                        // Update URL without page refresh
                        const url = new URL(window.location);
                        if (service) {
                            url.searchParams.set('service', service);
                        } else {
                            url.searchParams.delete('service');
                        }
                        url.searchParams.set('day', day);
                        window.history.pushState({}, '', url);

                        // Remove loading state
                        serviceFilter.disabled = false;
                        dayFilter.disabled = false;
                        if (profileBox) profileBox.classList.remove('loading');
                        if (serviceBox) serviceBox.classList.remove('loading');
                    })
                    .catch(error => {
                        console.error('Error updating analytics:', error);
                        // Restore original values on error
                        if (profileCount) profileCount.textContent = '{{ $profileCurrentCount }}';
                        if (serviceCount) serviceCount.textContent = '{{ $serviceCurrentCount }}';

                        // Remove loading state
                        serviceFilter.disabled = false;
                        dayFilter.disabled = false;
                        if (profileBox) profileBox.classList.remove('loading');
                        if (serviceBox) serviceBox.classList.remove('loading');

                        // Show error message
                        alert('Analiz verileri yüklenirken bir hata oluştu. Lütfen tekrar deneyin.');
                    });
            }

            // Add event listeners
            serviceFilter.addEventListener('change', updateAnalytics);
            dayFilter.addEventListener('change', updateAnalytics);
        }

        // Handle tab state preservation on pagination
        function preserveActiveTab() {
            // Check if there's a hash in the URL or a stored active tab
            const hash = window.location.hash;
            const storedTab = localStorage.getItem('activeTab');
            const urlParams = new URLSearchParams(window.location.search);

            // Check which pagination parameters exist to determine correct tab
            let correctTab = null;
            if (urlParams.has('followers_page')) {
                correctTab = 'takipci';
            } else if (urlParams.has('followings_page')) {
                correctTab = 'takipedilen';
            } else if (urlParams.has('questions_page')) {
                correctTab = 'profile';
            } else if (urlParams.has('ratings_page')) {
                correctTab = 'contact';
            } else if (urlParams.has('services_page') || urlParams.has('page')) {
                correctTab = 'home';
            }

            // If we have a pagination parameter, use that tab, otherwise use hash or stored tab
            const targetTab = correctTab || (hash ? hash.substring(1) : storedTab);

            if (targetTab) {
                const tabButton = document.querySelector(`[data-bs-target="#${targetTab}"]`);
                if (tabButton) {
                    // Remove active class from all tabs
                    document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
                        tab.classList.remove('active');
                    });
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });

                    // Activate the target tab
                    tabButton.classList.add('active');
                    const targetPane = document.querySelector(`#${targetTab}`);
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }

                    // Update localStorage and URL hash
                    localStorage.setItem('activeTab', targetTab);
                    if (!window.location.hash || window.location.hash !== `#${targetTab}`) {
                        window.history.replaceState(null, null, `${window.location.pathname}${window.location.search}#${targetTab}`);
                    }
                }
            }

            // Store active tab when clicked
            document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
                tab.addEventListener('click', function() {
                    const target = this.getAttribute('data-bs-target');
                    if (target) {
                        const tabId = target.substring(1);
                        localStorage.setItem('activeTab', tabId);

                        // Clear pagination parameters when switching tabs and update URL
                        const url = new URL(window.location);

                        // Remove all pagination parameters
                        url.searchParams.delete('page');
                        url.searchParams.delete('services_page');
                        url.searchParams.delete('questions_page');
                        url.searchParams.delete('followers_page');
                        url.searchParams.delete('followings_page');
                        url.searchParams.delete('ratings_page');

                        // Set hash for the active tab
                        url.hash = `#${tabId}`;

                        // Update URL without page reload
                        window.history.replaceState(null, null, url.toString());
                    }
                });
            });

            // Update pagination links to preserve active tab and clean other pagination params
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const activeTab = document.querySelector('.nav-tabs .nav-link.active');
                    if (activeTab) {
                        const target = activeTab.getAttribute('data-bs-target');
                        if (target) {
                            const tabId = target.substring(1);
                            const url = new URL(this.href);

                            // Remove all other pagination parameters except the one for current tab
                            const currentPageParam = url.searchParams.get('page') ||
                                url.searchParams.get('services_page') ||
                                url.searchParams.get('questions_page') ||
                                url.searchParams.get('followers_page') ||
                                url.searchParams.get('followings_page') ||
                                url.searchParams.get('ratings_page');

                            // Clear all pagination params
                            url.searchParams.delete('page');
                            url.searchParams.delete('services_page');
                            url.searchParams.delete('questions_page');
                            url.searchParams.delete('followers_page');
                            url.searchParams.delete('followings_page');
                            url.searchParams.delete('ratings_page');

                            // Set the correct pagination parameter for current tab
                            if (tabId === 'home') {
                                url.searchParams.set('services_page', currentPageParam || '1');
                            } else if (tabId === 'profile') {
                                url.searchParams.set('questions_page', currentPageParam || '1');
                            } else if (tabId === 'contact') {
                                url.searchParams.set('ratings_page', currentPageParam || '1');
                            } else if (tabId === 'takipci') {
                                url.searchParams.set('followers_page', currentPageParam || '1');
                            } else if (tabId === 'takipedilen') {
                                url.searchParams.set('followings_page', currentPageParam || '1');
                            }

                            url.hash = `#${tabId}`;
                            this.href = url.toString();
                        }
                    }
                });
            });
        }

        // Initialize tab preservation
        preserveActiveTab();
    });
</script>
@endsection