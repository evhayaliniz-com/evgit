<div class="popular-services one-cikan-firmalar">
    <div class="cs-title d-flex cs-title-link">
        <div class="ctl-left">
            <i class="fa-solid fa-building"></i>
            <h2> Öne Çıkan Firmalar </h2>
        </div>
        <div class="ctl-right">
            <a href="{{route('companies.index')}}"> Tüm Firmalar <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="popular-slider one-cikan-firmalar-slider">
        <div class="swiper mySwiper5">
            <div class="swiper-wrapper">
                @foreach($companies as $company)
                    <div class="swiper-slide">
                        <div class="popular-services-cards">
                            <div class="one-cikanlar-top">
                                <div class="one-cikan-box">
                                    <div class="one-cikan-img">
                                        <a href="{{route('companies.show', $company->slug)}}">
                                            <img src="{{asset($company->avatar)}}"
                                                 style="width: 50px !important; height: 50px !important"
                                                 alt="Avatar">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="psd-texts">
                                <div class="one-cikan-title">
                                    <a href="{{route('companies.show', $company->slug)}}" class="d-flex">
                                        <h3 class="d-inline"> {{$company->name}} </h3>
                                        @if($company->is_verified == 1)
                                            <img src="{{asset('site/images/success.png')}}" alt="Verified"
                                                 style="width: 18px !important; height: 18px; margin-top: 5px;">
                                        @endif
                                    </a>
                                </div>

                                <div class="psd-texts-icons">
                                    <div class="pti-area">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span> {{$company->provinceInfo->name . ' / ' . $company->districtInfo->name}} </span>
                                    </div>
                                    <div class="pti-area">
                                        <i class="fa-solid fa-business-time"></i>
                                        <span> {{$company?->category?->name . ' / ' . $company?->subCategory?->name}} </span>
                                    </div>
                                </div>
                                <div class="one-cikan-stars">
                                    <div class="stars-box">
                                        @php
                                            $averageRating = $company->ratings->avg('rating') ?? 0;
                                            $fullStars = floor($averageRating);
                                            $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                                            $ratingCount = $company->ratings->count();
                                        @endphp

                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fa-solid fa-star text-warning"></i>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                            @else
                                                <i class="fa-regular fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="stars-point">
                                        <span>
                                            @if($ratingCount > 0)
                                                {{ number_format($averageRating, 1) }} ({{ $ratingCount }})
                                            @else
                                                Puan Yok
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
