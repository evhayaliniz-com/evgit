@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="tum-hizmetler">
                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-slider tum-hizmetler-top"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>
                            Fikirlerim
                        </h5>

                        <div class="form-group d-flex gap-3" style="position:relative; top: 20px">
                            <a href="{{route('idea.create')}}" class="btn btn-info text-white"
                               style="height: 37px">Oluştur</a>

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
                    <div class="container-fluid firma-services-tab">
                        <div class="row">
                            @foreach($ideas as $idea)
                                <div class="col-md-6 col-lg-3">
                                    <div class="popular-services-cards">
                                        <div class="psc-img position-relative">
                                            @if($idea->category_id)
                                                <div class="psc-dekor">
                                                    {{$idea?->category?->name}}
                                                </div>
                                            @endif

                                            {{-- Onay durumu badge'i --}}
                                            <div class="psc-dekor" style="top: auto; bottom: 10px; left: 10px; right: auto;
                                                background-color: {{ $idea->is_confirmed ? '#28a745' : '#ffc107' }};
                                                font-size: 0.75rem; padding: 4px 8px;">
                                                @if($idea->is_confirmed)
                                                    <i class="fa-solid fa-check-circle"></i> Onaylandı
                                                @else
                                                    <i class="fa-solid fa-clock"></i> Onay Bekleniyor
                                                @endif
                                            </div>

                                            <a href="{{route('idea.show', $idea->slug)}}">
                                                <img src="{{asset(json_decode($idea->path)[0] ?? null)}}"
                                                     alt="{{$idea->title}}">
                                            </a>

                                                <div class="fpedit-decor">
                                                    <div class="firma-profil-edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                        Düzenle
                                                    </div>
                                                    <div class="firma-profil-edit-box bg-white">
                                                        <div class="d-flex">
                                                            <a href="{{route('idea.edit', $idea->id)}}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                Düzenle
                                                            </a>
                                                        </div>

                                                        <div class="d-flex remove">
                                                            <form action="{{ route('idea.destroy', $idea->id) }}"
                                                                  method="POST" class="d-inline"
                                                                  onsubmit="return ">
                                                                @csrf

                                                                @method('DELETE')
                                                                <a href="javascript:void(0)"
                                                                   onclick="if(confirm('Bu fikri silmek istediğinize emin misiniz?'))
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
                                                    <div class="fikir-img">
                                                        @php
                                                            // Kullanıcı bilgilerini al, eğer yoksa null döner
                                                            $user = auth_info($idea->user_id);
                                                            $ideaUserModel = \App\Models\User::find($idea->user_id);
                                                            // Avatar yolu veya varsayılan resim
                                                            $avatar = $user && $user->avatar
                                                                ? $user->avatar
                                                                : 'site/images/default_avatar.jpg';
                                                            // Gösterilecek isim
                                                            $name = $user && $user->name
                                                                ? $user->name
                                                                : 'Anonim';
                                                        @endphp

                                                        @if($user && $ideaUserModel)
                                                            @if($ideaUserModel->user_type === 'company' && $ideaUserModel->company)
                                                                <a href="{{ route('companies.show', $ideaUserModel->company->slug) }}" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                                                    <img
                                                                        src="{{ asset($avatar) }}"
                                                                        alt="{{ $name }}"
                                                                        style="width: 30px !important; height: 30px !important; border-radius: 50%; object-fit: cover; margin-right: 8px;"
                                                                    >
                                                                    <span>{{ $name }}</span>
                                                                </a>
                                                            @else
                                                                <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                                                    <img
                                                                        src="{{ asset($avatar) }}"
                                                                        alt="{{ $name }}"
                                                                        style="width: 30px !important; height: 30px !important; border-radius: 50%; object-fit: cover; margin-right: 8px;"
                                                                    >
                                                                    <span>{{ $name }}</span>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <div style="display: flex; align-items: center;">
                                                                <img
                                                                    src="{{ asset('site/images/default_avatar.jpg') }}"
                                                                    alt="Anonim"
                                                                    style="width: 30px !important; height: 30px !important; border-radius: 50%; object-fit: cover; margin-right: 8px;"
                                                                >
                                                                <span>Anonim</span>
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
                                                    <div class="fbs-boxes">
                                                        <i class="fa-solid fa-heart"></i>
                                                        <span>
                                                        {{$idea->ideaReplyLikeCount($idea->id)}}
                                                    </span>
                                                    </div>

                                                    <div class="fbs-boxes">
                                                        <i class="fa-solid fa-comment"></i>
                                                        <span>
                                                        {{$idea->replies->count()}}
                                                    </span>
                                                    </div>
                                                    <div class="fbs-boxes">
                                                        <i class="fa-solid fa-eye"></i>
                                                        <span>
                                                            {{$idea->ideaViewCount($idea->id)}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="fbs-right">
                                                    <a href="javascript:void(0)" class="share-btn"
                                                       data-url="{{route('idea.show', $idea->slug)}}">
                                                        <i class="fa-solid fa-share-nodes"></i>
                                                    </a>
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
            </div>
        </div>
    </div>
@endsection
