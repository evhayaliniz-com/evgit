@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="tum-hizmetler">
                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-slider tum-hizmetler-top">
                        <x-slider/>
                    </div>
                    <h5 class="mobile-small-title" style="top: 16px">Fikirler</h5>
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

                            <div class="tum-fikirler-arama">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="q" placeholder="Fikirlerde Ara..."
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
                                    <a href="{{route('idea.index')}}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                                @if(request()->category)
                                    <span>{{\App\Models\Category::select('name')->whereId(request()->category)->first()?->name}}</span>
                                    /
                                @endif

                                @if(request()->sub_category)
                                    <span>{{\App\Models\Category::select('name')->where('parent_id', request()->category)
                                            ->whereId(request()->sub_category)->first()?->name}}</span>
                                    /
                                @endif
                            </div>
                            <b>{{$ideaCount}}</b>
                            <small class="mobile-extrasmall-title">Fikir Bulundu</small>
                        </div>
                    </div>

                    <div class="tum-hizmetler-inner">
                        <div class="row">
                            @foreach($ideas as $idea)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                                    @include('site.idea.partials.single-idea-card', ['idea' => $idea])
                                </div>
                            @endforeach

                            <div class="col-lg-12">
                                {{$ideas->links()}}
                            </div>
                        </div>
                    </div>
                    <footer class="mt-0">
                        <p class="mb-0">
                            {{str_replace(['http://', 'https://'], '', env('APP_URL'))}}'da yer alan üyelerin oluşturduğu tüm içerik, görüş ve bilgilerin doğruluğu,
                            eksiksiz ve değişmez olduğu, yayınlanması ile ilgili yasal yükümlülükler içeriği oluşturulan
                            üyeye aittir. Bu içeriğin, görüş ve bilgilerin yanlışlık, eksiklik veya yasalarla
                            düzenlenmiş kurallara aykırılığından {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} hiç bir şekilde sorumlu değildir.
                            Sorularınız için içerik sahibi ile irtibata geçebilirsiniz.
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
