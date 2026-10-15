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
                    {{-- Header Altı İnce (Leaderboard) Reklam Alanı --}}
                    <div class="tum-hizmetler-slider tum-hizmetler-top header-leaderboard-ad text-center mb-3">
                        <x-ad-slot format="horizontal" class="leaderboard-ad-top" />
                    </div>

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
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                                    @include('site.company.partials.single-company-card', ['company' => $company])
                                </div>

                                {{-- Mobilde her 4 içerikten sonra duyarlı reklam --}}
                                @if($loop->iteration % 4 == 0)
                                    <div class="col-12 d-block d-md-none mb-4 text-center">
                                        <div class="p-2 bg-light rounded">
                                            <x-ad-slot format="auto" />
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            {{-- Web/Masaüstü: Sayfa altı yatay reklam --}}
                            <div class="col-12 d-none d-md-block my-4 text-center">
                                <x-ad-slot format="auto" />
                            </div>

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
