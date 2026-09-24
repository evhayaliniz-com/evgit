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
                                <div class="col-md-6 col-lg-3">
                                    <div class="popular-services-cards">
                                        <div class="psc-img">
                                            @if($idea->category_id)
                                                <div class="psc-dekor">
                                                    {{$idea?->category?->name}}
                                                </div>
                                            @endif

                                            <a href="{{route('idea.show', $idea->slug)}}">
                                                <img src="{{asset(json_decode($idea->path)[0] ?? null)}}"
                                                     alt="{{$idea->title}}">
                                            </a>
                                        </div>
                                        <div class="psd-texts">
                                            <div class="fikir-texts">
                                                <a href="{{route('idea.show', $idea->slug)}}" class="fw-bold mb-1"
                                                   style="font-size: 1.1rem">
                                                    {{$idea->title}}
                                                </a>
                                                <p class="mb-0 text-truncate-3">
                                                    {{$idea->content}}
                                                </p>
                                            </div>
                                            <div class="psd-texts-icons">
                                                <div class="pti-area">
                                                    @php
                                                        $userInfo = auth_info($idea->user_id);
                                                        $ideaUserModel = \App\Models\User::find($idea->user_id);
                                                    @endphp

                                                    <div class="fikir-img">
                                                        @if($userInfo && $ideaUserModel)
                                                            @if($ideaUserModel->user_type === 'company' && $ideaUserModel->company)
                                                                <a href="{{ route('companies.show', $ideaUserModel->company->slug) }}" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                                                    <img src="{{ asset($userInfo->avatar) }}"
                                                                         alt="{{ $userInfo->name }}"
                                                                         style="width: 30px !important; height: 30px !important; border-radius: 100%; margin-right: 8px;">
                                                                    <span>{{ $userInfo->name }}</span>
                                                                </a>
                                                            @else
                                                                <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                                                    <img src="{{ asset($userInfo->avatar) }}"
                                                                         alt="{{ $userInfo->name }}"
                                                                         style="width: 30px !important; height: 30px !important; border-radius: 100%; margin-right: 8px;">
                                                                    <span>{{ $userInfo->name }}</span>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <div style="display: flex; align-items: center;">
                                                                <img src="{{ asset('default-avatar.jpg') }}"
                                                                     alt="Bilinmeyen Kullanıcı"
                                                                     style="width: 30px !important; height: 30px !important; border-radius: 100%; margin-right: 8px;">
                                                                <span>Bilinmeyen Kullanıcı</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="pti-area">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <span> {{\Carbon\Carbon::parse($idea->created_at)->format('d.m.Y')}} </span>
                                                </div>
                                            </div>
                                            <div class="fikir-bottom-side">
                                                <div class="fbs-left">
                                                    <div class="fbs-boxes @if($idea->ideaLikeExists($idea->id)) liked @endif"
                                                         onclick="ideaLike('{{$idea->slug}}')">
                                                        <i class="fa-solid fa-heart"></i>
                                                        <span>
                                                            {{$idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id)}}
                                                        </span>
                                                    </div>

                                                    <div class="fbs-boxes">
                                                        <a href="{{route('idea.show', $idea->slug)}}?comment=show">
                                                            <i class="fa-solid fa-comment"></i>
                                                            <span>{{$idea->replies->count()}}</span>
                                                        </a>
                                                    </div>
                                                    <div class="fbs-boxes">
                                                        <i class="fa-solid fa-eye"></i>
                                                        <span>
                                                            {{$idea->ideaViewCount($idea->id)}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="psd-prices">
                                                    <div class="psd-prices-left">
                                                        <div class="fbs-right">
                                                            <div class="fiyat-gecmisi-trigger fw-normal">
                                                                <i class="fa-solid fa-share-nodes"></i> Paylaş
                                                            </div>
                                                            <div class="fiyat-gecmisi-area copy-area">
                                                                <div class="fiyat-gecmisi-giris">
                                                                    <div class="fiyat-gecmisi-close">
                                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                                    </div>
                                                                    <a href="javascript:void(0)"
                                                                       class="share-btn fw-normal"
                                                                       data-url="{{route('idea.show', $idea->slug)}}"
                                                                       onclick="copyToClipboard(this)">
                                                                        <i class="fa-solid fa-share-nodes me-2 pt-1"></i>
                                                                        Kopyala
                                                                    </a>

                                                                    {{--                                                                    <div class="bottomarrow"></div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
