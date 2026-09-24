<div class="popular-services">
    <div class="cs-title d-flex cs-title-link">
        <div class="ctl-left">
            <i class="fa-solid fa-comment"></i>
            <h2> Fikir Köşesi </h2>
        </div>
        <div class="ctl-right">
            <a href="{{route('idea.index')}}"> Tüm Fikirler <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
    </div>
    <div class="popular-slider fikir-kosesi">
        <div class="swiper mySwiper4">
            <div class="swiper-wrapper">
                @foreach($ideas as $idea)
                    <div class="swiper-slide">
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
                                        <div class="fikir-img">
                                            @php
                                                $user = auth_info($idea->user_id);
                                                $ideaUserModel = \App\Models\User::find($idea->user_id);
                                                $avatar = $user && $user->avatar
                                                    ? $user->avatar
                                                    : 'site/images/default_avatar.jpg';
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
                                        <div class="fbs-boxes @if($idea->ideaLikeExists($idea->id)) liked @endif"
                                             @auth() onclick="ideaLike('{{$idea->slug}}')" @endauth
                                             @guest() onclick="showLoginPopup('Beğenmek için giriş yapmalısınız!', this)" @endguest>
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
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
