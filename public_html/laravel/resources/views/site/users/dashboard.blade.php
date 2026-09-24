@extends('site.inc.master')

@section('css')

@endsection

@section('content')
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">
    <!-- Head kısmı master layout'ta tanımlı -->

    <body>
    <!-- Header master layout'ta tanımlı -->

    <div class="mobile-fixed-menu">
        <!-- Mobil menü master layout'ta tanımlı -->
    </div>

    <div class="main main-inner">
        <div class="container-fluid pr-0 mobile-mobile-pl-0 mobile-pl-0-edit pl-0">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
                    <div class="index-right bireysel-uye-profili">
                        <div class="firma-profil-box">
                            <div class="firma-profil-top"></div>
                            <div class="firma-profil-in">
                                <div class="firma-profil-logo">
                                    <img src="{{ asset(auth()->user()->informations->avatar ?? auth()->user()->avatar ?? 'site/images/default_avatar.jpg') }}" alt="Profil Resmi">
                                </div>
                                <div class="firma-profil-membership fpm-web">
                                    <div class="fp-edit">
                                        <a href="{{route('user.profile.edit')}}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Profili Düzenle</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="firma-profil-informations">
                                    <div class="fpi-title d-flex">
                                        <div >
                                            <h1>{{ auth()->user()->informations->name ?? auth()->user()->name ?? 'Kullanıcı' }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="firma-profil-membership fpm-mobil">
                                    <div class="fp-edit">
                                        <a href="{{route('user.profile.edit')}}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Profili Düzenle</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="firma-tabs-area">
                            <div class="firma-tabs-box">
                                <ul class="nav nav-tabs firma-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Fikirler</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="takipci-tab" data-bs-toggle="tab" data-bs-target="#takipci" type="button" role="tab" aria-controls="takipci" aria-selected="false">Takipçi</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="takipedilen-tab" data-bs-toggle="tab" data-bs-target="#takipedilen" type="button" role="tab" aria-controls="takipedilen" aria-selected="false">Takip Edilen</button>
                                    </li>
                                </ul>
                                <div class="tab-content mb-5" id="myTabContent">
                                    <div  class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="container-fluid firma-services-tab">
                                            <div class="row ps-1 ps-md-0">
                                                @foreach($ideas as $idea)
                                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                                        <div class="popular-services-cards">
                                                            <div class="psc-img">
                                                                @if($idea->category_id)
                                                                    <div class="psc-dekor">
                                                                        {{$idea?->category?->name}}
                                                                    </div>
                                                                @endif
                                                                <div class="fpedit-decor">
                                                                    <div class="firma-profil-edit">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                        Düzenle
                                                                    </div>
                                                                    <div class="firma-profil-edit-box">
                                                                        <div class="d-flex">
                                                                            <a href="{{route('idea.edit', $idea->id)}}">
                                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                                Düzenle
                                                                            </a>
                                                                        </div>
                                                                        <div class="d-flex remove">
                                                                            <form action="{{ route('idea.destroy', $idea->id) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <a href="javascript:void(0)" onclick="if(confirm('Bu fikri silmek istediğinize emin misiniz?')) this.closest('form').submit()">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                    Sil
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="{{route('idea.show', $idea->slug)}}">
                                                                    <img src="{{asset(json_decode($idea->path)[0] ?? null)}}" alt="{{$idea->title}}">
                                                                </a>
                                                            </div>
                                                            <div class="psd-texts">
                                                                <div class="fikir-texts">
                                                                    <p class="mb-0">
                                                                        {{str()->limit($idea->content, 100)}}
                                                                    </p>
                                                                </div>
                                                                <div class="psd-texts-icons">
                                                                    <div class="pti-area">
                                                                        <div class="fikir-img">
                                                                            @php
                                                                                $user = auth_info($idea->user_id);
                                                                                $avatar = $user && $user->avatar ? $user->avatar : 'site/images/default_avatar.jpg';
                                                                                $name = $user && $user->name ? $user->name : 'Anonim';
                                                                            @endphp
                                                                            <img style="max-width: 20px; max-height: 20px;" src="{{ asset($avatar) }}" alt="{{ $name }}">
                                                                            <span>{{ $name }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pti-area">
                                                                        <i class="fa-solid fa-location-dot"></i>
                                                                        <span>{{\Carbon\Carbon::parse($idea->created_at)->format('d.m.Y')}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="fikir-bottom-side">
                                                                    <div class="fbs-left">
                                                                        <div class="fbs-boxes">
                                                                            <i class="fa-solid fa-heart"></i>
                                                                            <span>245</span>
                                                                        </div>
                                                                        <div class="fbs-boxes">
                                                                            <i class="fa-solid fa-comment"></i>
                                                                            <span>{{$idea->replies->count()}}</span>
                                                                        </div>
                                                                        <div class="fbs-boxes">
                                                                            <i class="fa-solid fa-eye"></i>
                                                                            <span>1520</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="fbs-right">
                                                                        <i class="fa-solid fa-share-nodes"></i>
                                                                        <span>Paylaş</span>
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
                                    </div>
                                    <div class="tab-pane fade" id="takipci" role="tabpanel" aria-labelledby="takipci-tab">
                                        <div class="tab-bg">
                                            <div class="takipci-head">
                                                <div class="takipci-input">
                                                    <form action="" method="GET">
                                                        <input name="follower_name" type="text" placeholder="Takipçi Ara" value="{{request()->follower_name}}">
                                                        <i class="fa-solid fa-magnifying-glass" onclick="this.closest('form').submit()"></i>
                                                    </form>
                                                </div>
                                                <div class="takipci-count">
                                                    <span>Takipçiler ({{$followersCount}})</span>
                                                </div>
                                            </div>
                                            <div class="takipci-body">
                                                @foreach($followers as $follower)
                                                    <div>
                                                        <div class="sorular-title d-flex takipci-title">
                                                            <div class="sorular-title-left">
                                                                <img src="{{asset(auth_info($follower->user_id)->avatar)}}" alt="{{auth_info($follower->user_id)->name}}" style="width: 60px; height: 60px">
                                                                <span>{{auth_info($follower->user_id)->name}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="takipci-links">
                                                            <ul>
                                                                <li>
                                                                    <a href="{{route('chat.show', $follower->user_id)}}">Mesaj</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{route('company.follow')}}" method="POST">
                                                                        <a href="#" onclick="this.closest('form').submit()">Takipten Çık</a>
                                                                        <input type="hidden" name="status" value="2">
                                                                        <input type="hidden" name="user" value="{{\Illuminate\Support\Facades\Crypt::encryptString($follower->user_id)}}">
                                                                        @csrf
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            {{$followers->links()}}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="takipedilen" role="tabpanel" aria-labelledby="takipedilen-tab">
                                        <div class="tab-bg">
                                            <div class="takipci-head">
                                                <div class="takipci-input">
                                                    <form action="" method="GET">
                                                        <input name="following_name" type="text" placeholder="Takip Edilen Ara" value="{{request()->following_name}}">
                                                        <i class="fa-solid fa-magnifying-glass" onclick="this.closest('form').submit()"></i>
                                                    </form>
                                                </div>
                                                <div class="takipci-count">
                                                    <span>Takip Edilen ({{$followingsCount}})</span>
                                                </div>
                                            </div>
                                            <div class="takipci-body">
                                                @foreach($followings as $following)
                                                    <div>
                                                        <div class="sorular-title d-flex takipci-title">
                                                            <div class="sorular-title-left">
                                                                <img src="{{asset(auth_info($following->to_id)->avatar)}}" alt="{{auth_info($following->to_id)->name}}" style="width: 60px; height: 60px">
                                                                <span>{{auth_info($following->to_id)->name}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="takipci-links">
                                                            <ul>
                                                                <li>
                                                                    <a href="{{route('chat.show', $following->to_id)}}">Mesaj</a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{route('company.follow')}}" method="POST">
                                                                        <a href="#" onclick="this.closest('form').submit()">Takipten Çık</a>
                                                                        <input type="hidden" name="user" value="{{\Illuminate\Support\Facades\Crypt::encryptString($following->to_id)}}">
                                                                        @csrf
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            {{$followings->links()}}
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

    <div class="firma-mobil-fixed-menu d-md-none">
        <ul>
            <li>
                <a href="{{route('chat.show', auth()->user()->id)}}" style="color: #4068e2; border-color: #4068e2" class="btn btn-outline-primary w-100 fw-bold border-2 rounded-3">Mesaj</a>
            </li>
        </ul>
    </div>

    <!-- Modal ve diğer scriptler master layout'ta tanımlı -->
    </body>
    </html>
@endsection
