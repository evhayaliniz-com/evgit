@extends('site.inc.master')

@section('css')
    <style>
        .mobile-fixed-menu {
            display: none;
        }

        .firma-mobil-fixed-menu {
            position: fixed;
            bottom: 0;
            right: 0;
            background: #fff;
            width: 100%;
            height: 56px;
            border-top: 1px solid #ddd;
        }

        .firma-mobil-fixed-menu ul {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 10px 20px;
        }

        .firma-mobil-fixed-menu ul a {
            display: grid;
            place-items: center;
            width: 100%;
            justify-content:center !important;
            height: 100%;
        }

        .rating-stars {
            direction: rtl;
            unicode-bidi: bidi-override;
            display: inline-block;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            color: #ddd;
            font-size: 24px;
            padding: 0 3px;
            cursor: pointer;
        }

        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #ffc107;
        }

        .degerlendirme-box {
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stars-box {
            color: #ffc107;
            font-size: 20px;
        }

        .profile-avatar-min {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right vh-100">
                <div class="firma-profil-box">
                    <div class="firma-profil-top">
                        @auth()
                            <div class="success-firma-profil sfp-mobil">
                                <div class="fp-edit">
                                    <a href="javascript:void(0)" class="share-btn btn btn-outline-primary button-outline button" style="color:#4284f2 !important;">
                                        <i class="fa-solid fa-share-nodes"></i>
                                        <span>
                                      Paylaş
                                   </span>
                                    </a>
                                </div>
                                <div class="fp-edit fp-pro">
                                    @if(auth()->user()->id != $company->user_id)
                                        <form action="{{route('company.follow')}}" method="POST">
                                            <a class="button-primary button" href="#" onclick="this.closest('form').submit()">
                                                <i class="fa-solid fa-crown"></i>

                                                @if(!auth()->user()->following($company->user_id))
                                                    <span>Takip Et</span>
                                                @else
                                                    <span>Takipten Çık</span>
                                                @endif
                                            </a>
                                            <input type="hidden" name="user"
                                                   value="{{\Illuminate\Support\Facades\Crypt::encryptString($company->user_id)}}">
                                            @csrf
                                        </form>
                                    @endif
                                </div>

                            </div>
                        @endauth
                    </div>

                    <div class="firma-profil-in" style="min-height: 160px">
                        <div class="firma-profil-logo">
                            @if($company->avatar)
                                <img src="{{asset($company->avatar)}}" alt="{{$company?->name}}">
                            @endif
                        </div>

                        <div class="firma-profil-membership fpm-web fpm-mobile-hidden">
                            @auth()
                                <div class="fp-edit">
                                    <a href="javascript:void(0)" class="share-btn btn btn-outline-primary button-outline button">
                                        <i class="fa-solid fa-share-nodes"></i>
                                        <span>
                                      Paylaş
                                   </span>
                                    </a>
                                </div>

                                <div class="fp-edit">
                                    <a class="button button-mid" href="{{route('chat.show', $company->user_id)}}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>
                                       Mesaj
                                    </span>
                                    </a>
                                </div>
                                <div class="fp-edit fp-pro">
                                    @if(auth()->user()->id != $company->user_id)
                                        <form action="{{route('company.follow')}}" method="POST">
                                            <a class="button-primary button" href="#" onclick="this.closest('form').submit()">
                                                <i class="fa-solid fa-crown"></i>

                                                @if(!auth()->user()->following($company->user_id))
                                                    <span>Takip Et</span>
                                                @else
                                                    <span>Takipten Çık</span>
                                                @endif
                                            </a>
                                            <input type="hidden" name="user"
                                                   value="{{\Illuminate\Support\Facades\Crypt::encryptString($company->user_id)}}">
                                            @csrf
                                        </form>
                                    @endif
                                </div>
                            @endauth


                            @guest()
                                <div class="fp-edit">
                                    <div class="psd-prices mt-0">
                                        <div class="psd-prices-left">
                                            <div class="fiyat-gecmisi-trigger">
                                                <a href="javascript:void(0)" class="share-btn fw-normal">
                                                    <i class="fa-solid fa-share-nodes"></i>
                                                    <span>
                                                      Paylaş
                                                   </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="fiyat-gecmisi-area">
                                            <div class="fiyat-gecmisi-giris">
                                                <div class="fiyat-gecmisi-close">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </div>
                                                <p class="mb-0">
                                                    işleme devam edebilmek için
                                                </p>
                                                <a href="#">
                                                    Giriş Yap
                                                </a>
                                                <div class="bottomarrow"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="psd-prices mt-0">
                                    <div class="psd-prices-left">
                                        <div class="fiyat-gecmisi-trigger">
                                            <div class="fp-edit">

                                                <a href="javascript:void(0)" class="share-btn fw-normal">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    <span>
                                                           Mesaj
                                                        </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="fiyat-gecmisi-area">
                                            <div class="fiyat-gecmisi-giris">
                                                <div class="fiyat-gecmisi-close">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </div>
                                                <p class="mb-0">
                                                    işleme devam edebilmek için
                                                </p>
                                                <a href="#">
                                                    Giriş Yap
                                                </a>
                                                <div class="bottomarrow"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="psd-prices mt-0">
                                    <div class="psd-prices-left">
                                        <div class="fiyat-gecmisi-trigger">
                                            <div class="fp-edit">

                                                <a href="javascript:void(0)" class="share-btn fw-normal">
                                                    <i class="fa-solid fa-crown"></i>
                                                    <span>
                                                           Takip Et
                                                        </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="fiyat-gecmisi-area">
                                            <div class="fiyat-gecmisi-giris">
                                                <div class="fiyat-gecmisi-close">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </div>
                                                <p class="mb-0">
                                                    işleme devam edebilmek için
                                                </p>
                                                <a href="#">
                                                    Giriş Yap
                                                </a>
                                                <div class="bottomarrow"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endguest
                        </div>

                        <div class="firma-profil-informations">
                            <div class="fpi-title d-flex">
                                <div class="d-flex gap-2">
                                    <h1>{{$company->name}}</h1>

                                    @if($company->is_verified == 1)
                                        <span class="d-inline-block tooltipp" tabindex="0" data-bs-toggle="popover"
                                              data-bs-trigger="click focus"
                                              data-bs-content="Firma bilgileri ve konumu, uzmanlarımız tarafından onaylanmıştır.">
                                               <span class="tooltiptext">Firma bilgileri ve konumu, uzmanlarımız tarafından onaylanmıştır.</span>
                                            <img src="{{asset('site/images/success.png')}}" alt="Verified"
                                                 style="width: 18px !important; height: 18px;">
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="fp-infos mt-3 mt-md-0">
                                <div class="fp-infos-box d-none d-md-block mt-0 mt-md-2">
                                    <i class="fa-solid fa-user"></i>
                                    <span>
                                        {{$company->authorized}}
                                    </span>
                                </div>

                                <div class="fp-infos-box mt-0 mt-md-2 d-block d-md-none">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <span>
                                        {{$company?->category?->name . ' / ' . $company?->subCategory?->name}}
                                    </span>
                                </div>


                                <div class="fp-infos-box mt-0 mt-md-2 d-block d-md-none">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>
                                        {{$company?->provinceInfo?->name . ' / ' . $company?->districtInfo?->name}}
                                    </span>
                                </div>

                                <div class="fp-infos-box mt-0 mt-md-2 d-none d-md-block">
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <span>
                                        {{$company->mobile_phone}}
                                    </span>
                                </div>

                            </div>

                            <div class="fp-infos mt-3 mt-md-0 d-none d-md-flex">
                                <div class="fp-infos-box">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <span>
                                        {{$company?->category?->name . ' / ' . $company?->subCategory?->name}}
                                    </span>
                                </div>

                                <div class="fp-infos-box">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>
                                        {{$company?->provinceInfo?->name . ' / ' . $company?->districtInfo?->name}}
                                    </span>
                                </div>
                            </div>


                            <div class="firma-sikayeti firma-social-icons my-2">
                                <div class="firma-sikayet-links d-md-none">
                                    <ul>
                                        <li>
                                            <a href="{{$company->instagram}}">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{$company->youtube}}">
                                                <i class="fa-brands fa-youtube"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{$company->facebook}}">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{$company->website}}">
                                                <i class="fa-solid fa-globe"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between">
                                <div class="firma-sikayet-links d-none d-md-block">
                                    <ul>
                                        @if($company->instagram)
                                            <li>
                                                <a href="{{$company->instagram}}">
                                                    <i class="fa-brands fa-instagram"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if($company->youtube)
                                            <li>
                                                <a href="{{$company->youtube}}">
                                                    <i class="fa-brands fa-youtube"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if($company->facebook)
                                            <li>
                                                <a href="{{$company->facebook}}">
                                                    <i class="fa-brands fa-facebook"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @if($company->website)
                                            <li>
                                                <a href="{{$company->website}}">
                                                    <i class="fa-solid fa-globe"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>


                                @auth()
                                    <div class="firma-sikayeti-button">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#firmasikayeti">
                                            Firma ile ilgili şikayetim var!
                                        </button>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    @auth()
                        <div class="firma-profil-membership fpm-mobil kfp-fpm-mobil">
                            <div class="fp-edit">
                                <a href="javascript:void(0)" class="share-btn">
                                    <i class="fa-solid fa-share-nodes"></i>
                                    <span>
                                      Paylaş
                                   </span>
                                </a>
                            </div>
                            <div class="fp-edit">
                                <a href="{{route('chat.show', $company->user_id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>
                                       Mesaj
                                    </span>
                                </a>
                            </div>
                            <div class="fp-edit fp-pro">
                                @if(auth()->user()->id != $company->user_id)
                                    <form action="{{route('company.follow')}}" method="POST">
                                        <a href="#" onclick="this.closest('form').submit()">
                                            <i class="fa-solid fa-crown"></i>

                                            @if(!auth()->user()->following($company->user_id))
                                                <span>Takip Et</span>
                                            @else
                                                <span>Takipten Çık</span>
                                            @endif
                                        </a>
                                        <input type="hidden" name="user"
                                               value="{{\Illuminate\Support\Facades\Crypt::encryptString($company->user_id)}}">
                                        @csrf
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endauth
                </div>

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
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                                    Değerlendirmeler
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="takipedilen-tab" data-bs-toggle="tab"
                                        data-bs-target="#takipedilen" type="button" role="tab"
                                        aria-controls="takipedilen"
                                        aria-selected="false">Hakkında
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="container-fluid firma-services-tab">

                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <h5 class="dashboard-title mb-0">Hizmetler ({{$serviceCount}})</h5>

                                        <form action="" method="GET">
                                            <select name="order_by" class="form-select"
                                                    onchange="this.closest('form').submit()"
                                                    style="width: 180px">
                                                <option value="">Standart Sıralama</option>
                                                <option value="price_asc" @selected(request()->order_by == 'price_asc')>
                                                    Fiyata Göre (Artan)
                                                </option>
                                                <option
                                                    value="price_desc" @selected(request()->order_by == 'price_desc')>
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
                                            <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                                                @include('site.services.partials.single-service-card', ['service' => $service])
                                            </div>
                                        @endforeach
                                    </div>

                                    {{$services->links()}}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="tab-bg">
                                    <div class="degerlendirmeler">
                                        <!-- Puanlama Formu -->
                                        @if(auth()->check() && !$company->ratings()->where('user_id', auth()->id())->exists() && auth()->user()->id != $company->user_id)
                                            <div class="degerlendirme-box">
                                                <h3 class="degerlendirme-title">
                                                    Firma Değerlendir
                                                </h3>
                                                <form id="ratingForm" action="{{ route('company.rating.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                                                    <div class="degerlendirme-inner">
                                                        <div class="mb-3">
                                                            <div class="rating-stars">
                                                                @for($i = 5; $i >= 1; $i--)
                                                                    <input type="radio" id="star{{$i}}" name="rating"
                                                                           value="{{$i}}" required>
                                                                    <label for="star{{$i}}"><i
                                                                            class="fa-solid fa-star"></i></label>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <textarea name="comment" class="form-control" rows="3"
                                                                      placeholder="Deneyimlerinizi paylaşın..."></textarea>
                                                        </div>
                                                        <button type="submit" class="button-primary button" id="ratingSubmitBtn">
                                                            <span class="btn-text">Değerlendirmeyi Gönder</span>
                                                            <span class="btn-loading d-none">
                                                                <i class="fa fa-spinner fa-spin"></i> Gönderiliyor...
                                                            </span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        <!-- Genel Puanlama Bilgisi -->
                                        <div class="degerlendirme-box">
                                            <h3 class="degerlendirme-title">
                                                Firma Değerlendirme
                                            </h3>
                                            <div class="degerlendirme-inner">
                                                <div class="d-flex align-items-center">
                                                    <div class="stars-box">
                                                        @php
                                                            $averageRating = $company->ratings()->avg('rating') ?? 0;
                                                            $fullStars = floor($averageRating);
                                                            $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                                                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                        @endphp

                                                        @for($i = 0; $i < $fullStars; $i++)
                                                            <i class="fa-solid fa-star text-warning"></i>
                                                        @endfor

                                                        @if($hasHalfStar)
                                                            <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                                        @endif

                                                        @for($i = 0; $i < $emptyStars; $i++)
                                                            <i class="fa-regular fa-star text-warning"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="degerlendirme-score ms-3">
                                                        <b>{{ number_format($averageRating, 1) }}/5</b>
                                                        <p class="mb-0">
                                                            {{ $company->ratings()->count() }} değerlendirme
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kullanıcı Değerlendirmeleri -->
                                        <div id="ratingsList">
                                        @foreach($company->ratings()->with(['user.informations', 'user.company'])->latest()->paginate(5) as $rating)
                                            <div class="degerlendirme-box">
                                                <div class="sorular-title d-flex degerlendirme-title2">
                                                    <div class="sorular-title-left">
                                                        @php
                                                            $user = $rating->user ?? null;
                                                            $userInfo = $user->informations ?? null;
                                                            $userCompany = $user->company ?? null;

                                                            $displayName = 'Silinmiş Kullanıcı';
                                                            $avatarPath = 'site/images/default-avatar.png';

                                                            if ($user) {
                                                                $displayName = $user->getDisplayName();
                                                                
                                                                // Kullanıcı tipine göre avatar kontrolü
                                                                if ($user->user_type === 'company' && $userCompany) {
                                                                    // Firma kullanıcısı - companies tablosundan avatar
                                                                    $companyAvatar = $userCompany->avatar ?? null;
                                                                    if ($companyAvatar && !empty(trim($companyAvatar))) {
                                                                        // Avatar path düzeltmesi - site/images/avatars/ klasörü
                                                                        if (str_starts_with($companyAvatar, 'site/images/avatars/')) {
                                                                            $avatarPath = $companyAvatar;
                                                                        } elseif (str_starts_with($companyAvatar, 'storage/')) {
                                                                            $avatarPath = $companyAvatar;
                                                                        } elseif (file_exists(public_path($companyAvatar))) {
                                                                            $avatarPath = $companyAvatar;
                                                                        } elseif (file_exists(public_path('site/images/avatars/' . basename($companyAvatar)))) {
                                                                            $avatarPath = 'site/images/avatars/' . basename($companyAvatar);
                                                                        } else {
                                                                            $avatarPath = 'site/images/default-avatar.png';
                                                                        }
                                                                    } else {
                                                                        $avatarPath = 'site/images/default-avatar.png';
                                                                    }
                                                                } else {
                                                                    // Bireysel kullanıcı - user_informations tablosundan avatar
                                                                    $userInfoAvatar = $userInfo->avatar ?? null;
                                                                    $userAvatar = $user->avatar ?? null;
                                                                    
                                                                    if ($userInfoAvatar && !empty(trim($userInfoAvatar))) {
                                                                        // Avatar path düzeltmesi - site/images/avatars/ klasörü
                                                                        if (str_starts_with($userInfoAvatar, 'site/images/avatars/')) {
                                                                            $avatarPath = $userInfoAvatar;
                                                                        } elseif (str_starts_with($userInfoAvatar, 'storage/')) {
                                                                            $avatarPath = $userInfoAvatar;
                                                                        } elseif (file_exists(public_path($userInfoAvatar))) {
                                                                            $avatarPath = $userInfoAvatar;
                                                                        } elseif (file_exists(public_path('site/images/avatars/' . basename($userInfoAvatar)))) {
                                                                            $avatarPath = 'site/images/avatars/' . basename($userInfoAvatar);
                                                                        } else {
                                                                            $avatarPath = 'site/images/default-avatar.png';
                                                                        }
                                                                    } elseif ($userAvatar && !empty(trim($userAvatar))) {
                                                                        // Avatar path düzeltmesi - site/images/avatars/ klasörü
                                                                        if (str_starts_with($userAvatar, 'site/images/avatars/')) {
                                                                            $avatarPath = $userAvatar;
                                                                        } elseif (str_starts_with($userAvatar, 'storage/')) {
                                                                            $avatarPath = $userAvatar;
                                                                        } elseif (file_exists(public_path($userAvatar))) {
                                                                            $avatarPath = $userAvatar;
                                                                        } elseif (file_exists(public_path('site/images/avatars/' . basename($userAvatar)))) {
                                                                            $avatarPath = 'site/images/avatars/' . basename($userAvatar);
                                                                        } else {
                                                                            $avatarPath = 'site/images/default-avatar.png';
                                                                        }
                                                                    } else {
                                                                        $avatarPath = 'site/images/default-avatar.png';
                                                                    }
                                                                }
                                                            }
                                                        @endphp

                                                        <img src="{{ asset($avatarPath) }}"
                                                             class="profile-avatar-min"
                                                             alt="{{ $displayName }}">
                                                        <span>{{ $displayName }}</span>
                                                    </div>
                                                    <div class="sorular-title-right">
                                                                <span class="degerlendirme-date">
                                                                    {{ $rating->created_at->format('d.m.Y') }}
                                                                </span>
                                                        @if($rating->user_id == auth()->id())
                                                            <form
                                                                action="{{ route('company.rating.destroy', $rating->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="btn btn-link text-danger p-0 ms-2"
                                                                        onclick="return confirm('Bu değerlendirmeyi silmek istediğinize emin misiniz?')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="degerlendirme-inner">
                                                    <div class="d-flex align-items-center">
                                                        <div class="stars-box">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $rating->rating)
                                                                    <i class="fa-solid fa-star text-warning"></i>
                                                                @else
                                                                    <i class="fa-regular fa-star text-warning"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="degerlendirme-bottom mt-2">
                                                        @if($rating->comment)
                                                            <p>{{ $rating->comment }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>

                                    <!-- Sayfalama -->
                                    <div class="pagination degerlendirme-pagination">
                                        {{ $company->ratings()->paginate(5)->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="takipedilen" role="tabpanel"
                                 aria-labelledby="takipedilen-tab">
                                <div class="tab-bg">
                                    <div class="firma-information">
                                        <div class="firma-tab-info-left">
                                            <h3>
                                                Hakkımızda
                                            </h3>
                                            <p>{{$company->about}}</p>
                                        </div>
                                        <div class="firma-tab-info-right">

                                            @if($company->lat && $company->lng)
                                                <div class="fpir-map">
                                                    <iframe
                                                        src="https://www.google.com/maps?q={{$company->lat}},{{$company->lng}}&output=embed"
                                                        width="100%" height="400" style="border:0;"
                                                        allowfullscreen="" loading="lazy"
                                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                            @endif
                                            <div class="ftir-texts">
                                                <div class="d-flex">
                                                    <b>
                                                        Firma Yetkilisi:
                                                    </b>
                                                    <h5>
                                                        {{$company->authorized ?? 'Belirtilmemiş'}}
                                                    </h5>
                                                </div>
                                                <div class="d-flex">
                                                    <b>
                                                        İletişim No:
                                                    </b>
                                                    <h5>
                                                        @if($company->mobile_phone)
                                                            {{$company->mobile_phone}}
                                                        @elseif($company->fixed_phone)
                                                            {{$company->fixed_phone}}
                                                        @else
                                                            Belirtilmemiş
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="d-flex">
                                                    <b>
                                                         Adres:
                                                    </b>
                                                    <h5>
                                                        {{$company->address ?? 'Belirtilmemiş'}}
                                                    </h5>
                                                </div>
                                                <div class="d-flex">
                                                <b>
                                                     İl:
                                                </b>
                                                  <span>
                                                 {{$company->provinceInfo->name}}
                                             </span>
                                                </div>
                                              <div class="d-flex">
                                                <b>
                                                İlçe:
                                                </b>
                                                    <span>
                                                  {{$company->districtInfo->name}}
                                             </span>
                                              </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @auth()
        <div class="modal fade login-modal" id="firmasikayeti" tabindex="-1" aria-labelledby="firmasikayetiLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="firmasikayetiLabel">Firma Şikayeti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('companies.report', $company->slug)}}" method="POST">
                            <div class="firma-sikayeti-box">
                            <textarea id="w3review" name="message" rows="4" cols="50" maxlength="4800" required
                                      placeholder="Şikayetiniz"></textarea>

                                @csrf
                                <div class="login-button">
                                    <button type="submit">
                                        Gönder
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="firma-mobil-fixed-menu d-md-none" style="height:60px !important;padding-top:0px !important;">
            <ul style="padding-top:7px !important;">
                <li>
                    <a href="{{route('chat.show', $company->user_id)}}" style="color: #4068e2; border-color: #4068e2"
                       class="btn btn-outline-primary w-100 fw-bold border-2 rounded-3 btn btn-outline-primary button-outline button">Mesaj</a>
                </li>
                <li>
                    <a href="tel:{{$company->mobile_phone}}"
                       class="btn w-100 fw-bold rounded-3 text-white button-primary button" style="background-color: #4068e2;">Ara</a>
                </li>
            </ul>
        </div>
    @endauth
@endsection
 @section('js')

{{--@section('js')--}}
{{--    <script>--}}
{{--        const btns = document.querySelectorAll('.share-btn');--}}

{{--        btns.forEach(e => {--}}
{{--            e.addEventListener('click', function () {--}}
{{--                const url = window.location.href;--}}
{{--                const btn = this;--}}

{{--                // URL'i panoya kopyala--}}
{{--                navigator.clipboard.writeText(url).then(() => {--}}
{{--                    // Buton içeriğini değiştir--}}
{{--                    btn.innerHTML = 'Panoya kopyalandı';--}}

{{--                    // 5 saniye sonra eski haline getir--}}
{{--                    setTimeout(() => {--}}
{{--                        btn.innerHTML = `--}}
{{--                    <i class="fa-solid fa-share-nodes"></i>--}}
{{--                    <span>Paylaş</span>--}}
{{--                `;--}}
{{--                    }, 5000);--}}
{{--                }).catch(err => {--}}
{{--                    console.error('Kopyalama başarısız:', err);--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab state management
    const urlHash = window.location.hash;
    if (urlHash === '#ratings') {
        // Activate ratings tab
        const ratingsTab = document.querySelector('a[href="#ratings"]');
        if (ratingsTab) {
            ratingsTab.click();
        }
    }
    
    const ratingForm = document.getElementById('ratingForm');
    const ratingSubmitBtn = document.getElementById('ratingSubmitBtn');
    const btnText = ratingSubmitBtn ? ratingSubmitBtn.querySelector('.btn-text') : null;
    const btnLoading = ratingSubmitBtn ? ratingSubmitBtn.querySelector('.btn-loading') : null;

    if (ratingForm) {
        ratingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Loading state
            ratingSubmitBtn.disabled = true;
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            
            // Form data
            const formData = new FormData(ratingForm);
            
            // AJAX request
            fetch(ratingForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success message
                    showNotification('Değerlendirmeniz başarıyla gönderildi!', 'success');
                    
                    // Add new rating to the list
                    if (data.rating) {
                        addNewRatingToList(data.rating);
                    }
                    
                    // Hide the rating form
                    const ratingFormBox = ratingForm.closest('.degerlendirme-box');
                    if (ratingFormBox) {
                        ratingFormBox.style.display = 'none';
                    }
                    
                    // Update rating statistics
                    updateRatingStats();
                } else {
                    // Error message
                    showNotification(data.message || 'Bir hata oluştu!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Bir hata oluştu!', 'error');
            })
            .finally(() => {
                // Reset button state
                ratingSubmitBtn.disabled = false;
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
            });
        });
    }
    
    // Add new rating to the list
    function addNewRatingToList(rating) {
        const ratingsList = document.getElementById('ratingsList');
        if (!ratingsList) return;
        
        // Create new rating HTML
        const newRatingHTML = createRatingHTML(rating);
        
        // Add to the top of the list
        ratingsList.insertAdjacentHTML('afterbegin', newRatingHTML);
    }
    
    // Create rating HTML
    function createRatingHTML(rating) {
        const user = rating.user;
        const displayName = user.display_name || 'Silinmiş Kullanıcı';
        const avatarPath = '{{ asset("") }}' + (user.avatar_path || 'site/images/default_avatar.jpg');
        const ratingDate = new Date(rating.created_at).toLocaleDateString('tr-TR');
        
        let starsHTML = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating.rating) {
                starsHTML += '<i class="fa-solid fa-star text-warning"></i>';
            } else {
                starsHTML += '<i class="fa-regular fa-star text-warning"></i>';
            }
        }
        
        return `
            <div class="degerlendirme-box">
                <div class="sorular-title d-flex degerlendirme-title2">
                    <div class="sorular-title-left">
                        <img src="${avatarPath}" class="profile-avatar-min" alt="${displayName}">
                        <span>${displayName}</span>
                    </div>
                    <div class="sorular-title-right">
                        <span class="degerlendirme-date">${ratingDate}</span>
                    </div>
                </div>
                <div class="degerlendirme-inner">
                    <div class="d-flex align-items-center">
                        <div class="stars-box">
                            ${starsHTML}
                        </div>
                    </div>
                    <div class="degerlendirme-bottom mt-2">
                        ${rating.comment ? `<p>${rating.comment}</p>` : ''}
                    </div>
                </div>
            </div>
        `;
    }
    
    // Update rating statistics
    function updateRatingStats() {
        // Rating statistics will be updated dynamically without page reload
        // No need to reload the page
    }
    
    // Notification function
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }
});
</script>

{{--@endsection--}}
@endsection