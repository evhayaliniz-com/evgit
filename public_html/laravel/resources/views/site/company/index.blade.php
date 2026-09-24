@extends('site.inc.master')

@section('css')
    <style>
    .one-cikan-img img {
        width: 70px !important;
        height: 70px !important;
    }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="tum-hizmetler">
                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-slider tum-hizmetler-top"></div>
                    <x-slider />

                    <h5 class="mobile-small-title" style="top: 16px">Firmalar</h5>
                </div>
                <div class="tum-hizmetler-inputs-flex">
                    <form action="" method="GET">
                        <div class="tum-hizmetler-inputs">
                            <div class="form-group">
                                <select name="category" class="form-select" onchange="getSubCategories()">
                                    <option value="">Kategori</option>
                                    @foreach(get_categories() as $category)
                                        <option value="{{$category->id}}" @selected(request()->category == $category->id)>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="sub_category" class="form-select" id="sub-category-select">
                                    <option value="">Alt Kategori</option>

                                    @if(request()->category)
                                        @foreach(get_sub_categories(request()->category) as $subCategory)
                                            <option
                                                    value="{{$subCategory->id}}" @selected(request()->sub_category == $subCategory->id)>
                                                {{$subCategory->name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="province" class="form-select" onchange="getDistricts()">
                                    <option value="">İl</option>
                                    @foreach(get_provinces() as $province)
                                        <option value="{{$province->id}}" @selected(request()->province == $province->id)>
                                            {{$province->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="district" class="form-select" id="district-select">
                                    <option value="">İlçe</option>

                                    @if(request()->province)
                                        @foreach(get_districts(request()->province) as $district)
                                            <option
                                                    value="{{$district->id}}" @selected(request()->district == $district->id)>
                                                {{$district->name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="tum-fikirler-arama">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="q" placeholder="Firmalarda Ara..."
                                               value="{{request()->q}}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group tum-hizmetler-inputs-flex-button ms-3 mt-1">
                                <button type="submit">
                                    Filtrele
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-filter-title">
                        <div class="thft-left">
                            <div class="thft-box">
                                @if(request()->all())
                                    <a href="{{route('companies.index')}}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                                @if(request()->category)
                                    <span>{{\App\Models\Category::select('name')->whereId(request()->category)->first()?->name}}</span>
                                    /
                                @endif

                                @if(request()->sub_category)
                                    <span>{{\App\Models\Category::select('name')->whereId(request()->sub_category)
                                    ->where('parent_id', request()->category)->first()?->name}}</span>/
                                @endif

                                @if(request()->province)
                                    <span>{{\App\Models\Province::select('name')->whereId(request()->province)->first()?->name}}</span>
                                    /
                                @endif

                                @if(request()->district)
                                    <span>{{\App\Models\District::select('name')->whereId(request()->district)
                                    ->where('city_id', request()->province)->first()?->name}}</span>
                                @endif
                            </div>
                            <b>{{$companyCount}}</b>
                            <small>Firma Bulundu</small>
                        </div>
                    </div>

                    <div class="tum-hizmetler-inner tum-firmalar-inner">
                        <div class="row">
                            @foreach($companies as $company)
                                <div class="col-lg-3">
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

                            {{$companies->links()}}
                        </div>
                    </div>
                    <footer class="mt-0">
                        <p class="mb-0">
                            {{str_replace(['http://', 'https://'], '', env('APP_URL'))}}'da yer alan üyelerin oluşturduğu tüm içerik, görüş ve bilgilerin doğruluğu,
                            eksiksiz ve değişmez olduğu, yayınlanması ile ilgili yasal yükümlülükler içeriği oluşturulan
                            üyeye aittir. Bu içeriğin, görüş ve bilgilerin yanlışlık, eksiklik veya yasalarla
                            düzenlenmiş
                            kurallara aykırılığından {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} hiç bir şekilde sorumlu değildir. Sorularınız için
                            içerik sahibi ile irtibata geçebilirsiniz.
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        window.addEventListener('scroll', _ => {
            scrollFilterAreaFixed()
        })
    </script>
@endsection
