<div class="hdzb-mobil-box fikir-detay-mobil-box @if(request()->comment == 'show') hdzb-mobil-show @endif">
    <div class="hdzb-mobil-top @if(request()->comment == 'show') hdzb-mobil-top-250 @endif">
        <div class="swiper mySwiper8">
            <div class="swiper-wrapper">
                @foreach(json_decode($idea->path, true) ?? [] as $path)
                    <div class="swiper-slide">
                        <div class="hdz-mobil-img">
                            <a class="hdz-mobil-fancy" href="{{asset($path)}}" data-fancybox="gallery"
                               data-caption="Ev Hayaliniz">
                                @if(get_file_extension($path) != 'mp4')
                                    <img src="{{asset($path)}}" style="width: 100%;"
                                         class="responsive-img" alt="Image">

                                @else
                                    <video controls style="width: 100%">
                                        <source src="{{asset($path)}}" style="width: 100%"/>
                                    </video>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="d-flex">
            <div class="hdzb-mobil-top-left">
                <a href="#" onclick="history.back(); return false;">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <a href="{{route('idea.index', ['category' => $idea->category_id, 'sub_category' => $idea->sub_category_id])}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="M6 19h3v-5q0-.425.288-.712T10 13h4q.425 0 .713.288T15 14v5h3v-9l-6-4.5L6 10zm-2 0v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-4q-.425 0-.712-.288T13 20v-5h-2v5q0 .425-.288.713T10 21H6q-.825 0-1.412-.587T4 19m8-6.75"></path>
                </svg>
              </a>
            </div>
            <div class="hdzb-mobil-top-right">
                <a href="javascript:void(0)" class="share-btn">
                    <i class="fa-solid fa-share-nodes"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="hdzb-mobil-texts eplan-mobil-texts bg-white">
        <div class="eplan-mobil-texts-title mb-3">
            <div class="eplan-mtt-left">
           <h3 class="text-truncate">
                 
                </h3>
            </div>
            <div class="eplan-mtt-right">
              <div class="eplan-mtt-fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <!-- Icon from Google Material Icons by Material Design Authors - https://github.com/material-icons/material-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="M21.29 4.12L16.7 8.71l1.59 1.59c.63.63.18 1.71-.71 1.71H13c-.55 0-1-.45-1-1v-4.6c0-.89 1.08-1.34 1.71-.71l1.59 1.59l4.59-4.59a.996.996 0 0 1 1.41 0c.38.4.38 1.03-.01 1.42M4.12 21.29l4.59-4.59l1.59 1.59c.63.63 1.71.18 1.71-.71V13c0-.55-.45-1-1-1h-4.6c-.89 0-1.34 1.08-.71 1.71l1.59 1.59l-4.59 4.59a.996.996 0 0 0 0 1.41c.4.38 1.03.38 1.42-.01"></path>
                </svg>
              </div>
              <div class="eplan-mtt-close more-hizmet2">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z"></path>
                </svg>
              </div>
            </div>
          </div>
        <div class="hdzb-mobil-list hdzb-mobil-list-blocks">
            <div class="hdzb-mobil-list-box">
                <span>{{$idea?->category?->name}}</span>
            </div>

            <div class="hdzb-mobil-list-box">
                <span>{{$idea?->subCategory?->name}}</span>
            </div>
        </div>
        <div class="hizmet-hakkinda-aciklama hdzb-mobil-aciklama">
            <div>
                <p style="border: 1px solid #ddd;border-radius:8px; padding: 5px 10px; max-height: 200px; overflow: auto !important;">
                    {{$idea->content}}
                </p>
            </div>

            <div class="hdzm-mobil-hizmet more-hizmet2">Daha Az</div>

            <div class="fikir-detay-mobil-comments">
                @if($replies->count() > 0)
                    <div class="fikir-detay-right-box">
                        @foreach($replies as $reply)
                            <div class="fdri-boxes">
                                <div class="fikir-detay-right-inputs">
                                    <div class="fdri-top d-flex justify-content-between">
                                        @php
                                            $replyUser = auth_info($reply->user_id);
                                        @endphp

                                        @if($replyUser)
                                          @php $user = \App\Models\User::find($reply->user_id); @endphp
                                          @if($user && $user->user_type === 'company' && $user->company)
                                            <a href="{{ route('companies.show', $user->company->slug) }}">
                                                <img src="{{ asset($replyUser->avatar ?? 'default-avatar.png') }}"
                                                     class="profile-avatar-min"
                                                     alt="{{ $replyUser->name }}">
                                                {{ $replyUser->name }}
                                            </a>
                                          @else
                                            <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                                                <img src="{{ asset($replyUser->avatar ?? 'default-avatar.png') }}"
                                                     class="profile-avatar-min"
                                                     alt="{{ $replyUser->name }}">
                                                {{ $replyUser->name }}
                                            </a>
                                          @endif
                                        @else
                                          <a href="#">
                                            <img src="{{ asset('default-avatar.png') }}" class="profile-avatar-min" alt="Bilinmeyen Kullanıcı">
                                            Bilinmeyen Kullanıcı
                                          </a>
                                        @endif

                                    @auth()
                                            @if($reply->user_id == auth()->user()->id
                                                || $reply->idea->user_id == auth()->user()->id)
                                                <a href="{{route('idea.reply.destroy', $reply->id)}}"
                                                   class="text-danger"
                                                   onclick="return confirm('Yorumu silmek istediğinize emin misiniz ?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            @endif
                                        @endauth
                                    </div>

                                    <p class="mb-0">{{$reply->content}}</p>

                                    <div class="fdrb-box d-flex mt-2 comment-like">
                                        <form action="" method="POST">
                                            @csrf
                                            <div class="like-area @if($reply->like($reply->id)) text-primary @endif"
                                                 onclick="likeToggle({{$reply->id}})">
                                                <i class="fa-regular fa-thumbs-up pt-1 me-1"></i>
                                                <span>{{$reply->likes->count()}}</span>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="fdri-date d-flex">
                                                    <span>
                                                        {{change_timezone($reply->created_at, 'H:i')}}

                                                        {{change_timezone($reply->created_at, 'd.m.Y')}}
                                                    </span>
                                    </div>
                                </div>
                                <div class="fikir-detay-answer-trigger">
                                    Yanıtla
                                </div>
                                <div class="fikir-detay-yanitla">
                                    @auth()
                                        <form action="{{route('idea.reply.store')}}" method="POST">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="content" required="">
                                                    <label>Yanıtla</label>

                                                    <input type="hidden" name="idea_id"
                                                           value="{{$idea->id}}">
                                                    <input type="hidden" name="parent_reply_id"
                                                           value="{{$reply->id}}">
                                                    <input type="hidden" name="quoted_reply_id"
                                                           value="{{$reply->id}}">
                                                </div>
                                            </div>

                                            @csrf
                                            <div class="text-right">
                                                <button type="submit">Gönder</button>
                                            </div>
                                        </form>
                                    @endauth

                                    @guest()
                                        <b class="d-block text-center">
                                            Yorum yapmak için lütfen
                                            <a href="#" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">giriş yapın.</a>
                                        </b>
                                    @endguest
                                </div>

                                @if ($reply->answers->count() > 0)
                                    <div class="fikir-detay-yanit-goster-gizle-trigger mb-3"
                                         role="button">
                                        - Yanitları Göster
                                    </div>
                                    <div class="fikir-detay-yanitlari-goster-gizle">
                                        {{-- Eğer yoruma cevaplar varsa --}}
                                        @foreach ($reply->answers as $answer)
                                            <div class="fikir-detay-right-inputs">
                                                <div class="fdri-top d-flex">
                                                    @php $answerUser = auth_info($answer->user_id); $answerUserModel = \App\Models\User::find($answer->user_id); @endphp
                                                    @if($answerUser && $answerUserModel)
                                                      @if($answerUserModel->user_type === 'company' && $answerUserModel->company)
                                                        <a href="{{ route('companies.show', $answerUserModel->company->slug) }}">
                                                          <img src="{{asset($answerUser->avatar)}}"
                                                               class="profile-avatar-min"
                                                               alt="{{$answerUser->name}}">
                                                          {{$answerUser->name}}
                                                        </a>
                                                      @else
                                                        <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                                                          <img src="{{asset($answerUser->avatar)}}"
                                                               class="profile-avatar-min"
                                                               alt="{{$answerUser->name}}">
                                                          {{$answerUser->name}}
                                                        </a>
                                                      @endif
                                                    @else
                                                      <img src="{{ asset('default-avatar.png') }}" class="profile-avatar-min" alt="Bilinmeyen Kullanıcı">
                                                      Bilinmeyen Kullanıcı
                                                    @endif
                                                </div>

                                                {{-- Eğer bu yanıt da başka bir yorumu alıntıladıysa --}}
                                                @if ($answer->quotedReply)
                                                    <!--<blockquote>
                                                        <small>{{ $answer->quotedReply->content }}</small>
                                                    </blockquote>-->
                                                @endif

                                                <p class="mb-0">
                                                    {{$answer->content}}
                                                </p>

                                                <div class="fdrb-box d-flex mt-2 comment-like">
                                                    <form action="" method="POST">
                                                        @csrf
                                                        <div
                                                            class="like-area @if($answer->like($answer->id)) text-primary @endif"
                                                            onclick="likeToggle({{$answer->id}})">
                                                            <i class="fa-regular fa-thumbs-up pt-1 me-1"></i>
                                                            <span>{{$answer->likes->count()}}</span>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="fdri-date d-flex">
                                                            <span>
                                                                {{change_timezone($answer->created_at, 'H:i')}}

                                                                {{change_timezone($answer->created_at, 'd.m.Y')}}
                                                            </span>
                                                </div>
                                            </div>

                                            <div class="fikir-detay-answer-trigger">
                                                Yanıtla
                                            </div>
                                            <div class="fikir-detay-yanitla">
                                                @auth()
                                                    <form action="{{route('idea.reply.store')}}"
                                                          method="POST">
                                                        <div class="form-group">
                                                            <div class="input-field">
                                                                <input type="text" name="content"
                                                                       required="">
                                                                <label>Yanıtla</label>

                                                                <input type="hidden" name="idea_id"
                                                                       value="{{$idea->id}}">
                                                                <input type="hidden"
                                                                       name="parent_reply_id"
                                                                       value="{{$reply->id}}">
                                                                <input type="hidden"
                                                                       name="quoted_reply_id"
                                                                       value="{{$answer->id}}">
                                                            </div>
                                                        </div>

                                                        @csrf
                                                        <div class="text-right">
                                                            <button type="submit">Gönder</button>
                                                        </div>
                                                    </form>
                                                @endauth

                                                @guest()
                                                    <b class="d-block text-center">
                                                        Yorum yapmak için lütfen
                                                        <a href="#" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">giriş yapın.</a>
                                                    </b>
                                                @endguest
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="hdzb-mobil-trigger-box w-100 hdzb-mobil-trigger @if(request()->comment == 'show') hide @endif">
        <div class="d-flex">
            <p class="text-truncate-3">{{$idea->content}}</p>
            <div class="hdzb-mobil-trigger-text">
                daha fazla
            </div>
        </div>
        <div class="hdzb-mobil-list">
            <div class="hdzb-mobil-list-box">
                                <span>
                                    {{$idea?->category?->name}}
                                </span>
            </div>
            <div class="hdzb-mobil-list-box">
                                <span>
                                    {{$idea?->subCategory?->name}}
                                </span>
            </div>
        </div>
    </div>
</div>

<div class="hdzb-mobil-bottom">
    <div class="hdzb-mobil-flex user-info @if(request()->comment == 'show') d-none @endif">
        <div class="hdzb-mobil-bottom-left">
            @php
                $userInfo = auth_info($idea->user_id);
            @endphp

            <div class="fikir-detay-mobil-bottom-left"
                 @if($idea->user->user_type === 'company' && $userInfo)
                     onclick="window.location.href = '{{ route('companies.show', $userInfo->slug) }}'"
                @endif
            >
                @if($userInfo)
                    <img src="{{ asset($userInfo->avatar) }}" alt="{{ $userInfo->name }}">
                    <span>{{ $userInfo->name }}</span>
                @else
                    <img src="{{ asset('default-avatar.jpg') }}" alt="Bilinmeyen Kullanıcı">
                    <span>Bilinmeyen Kullanıcı</span>
                @endif
            </div>

        </div>
        <div class="hdzb-mobil-bottom-right">
            <div class="fikir-detay-mobil-bottom-right">
                <div class="fdrb-icons d-flex">
                    <div class="fdrb-box d-flex" id="comment-toggle-button">
                        <i class="fa-regular fa-comment"></i>
                        <span id="mobile-comment-count">{{$idea->replies->count()}}</span>
                    </div>
                    <div class="fdrb-box d-flex @if($idea->ideaLikeExists($idea->id)) liked @endif"
                         onclick="ideaLike('{{$idea->slug}}')">
                        <i class="fa-regular fa-thumbs-up"></i>
                        <span>
                                {{$idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id)}}
                            </span>
                    </div>
                    <div class="fdrb-box d-flex">
                        <i class="fa-regular fa-eye"></i>
                        <span>
                                {{$idea->ideaViewCount($idea->id)}}
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="fikir-detay-right-bottom" id="mobile-comments-section"
         style="@if(request()->comment != 'show') display: none; @endif">

        <!-- Kapatma butonu -->
        <div class="mobile-comment-header">
            <button class="mobile-comment-close-btn" onclick="closeComments()">
                <span>Yorumları Kapat</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z"></path>
                </svg>
            </button>
        </div>

        <div class="fdbr-textarea bg-white" @guest() style="box-shadow: none" @endguest>
            @auth()
                <form action="{{route('idea.reply.store')}}" method="POST">
                    <div class="mobile-reply-area">
                        <input type="text" name="content" placeholder="Yorumunuzu yazın..."
                               class="form-control" value="{{old('content')}}" required>
                        <button type="submit">
                            <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </div>

                    <input type="hidden" name="idea_id" value="{{$idea->id}}">

                    @csrf
                </form>
            @endauth

            @guest()
                <b class="d-block text-center">
                    Yorum yapmak için lütfen <a href="#" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">giriş yapın.</a>
                </b>
            @endguest
        </div>

        <!-- Yorumların gösterileceği alan -->
        <div class="fikir-detay-mobil-comments">
            @if($replies->count() > 0)
                <div class="fikir-detay-right-box">
                    @foreach($replies as $reply)
                        <!-- Yorum kartları burada gösterilecek -->
                        <div class="fdri-boxes">
                            <div class="fikir-detay-right-inputs">
                                <div class="fdri-top d-flex justify-content-between">
                                    @php
                                        $user = auth_info($reply->user_id);
                                    @endphp

                                    @php $commentUser = auth_info($reply->user_id); $commentUserModel = \App\Models\User::find($reply->user_id); @endphp
                                    @if($commentUser && $commentUserModel)
                                      @if($commentUserModel->user_type === 'company' && $commentUserModel->company)
                                        <a href="{{ route('companies.show', $commentUserModel->company->slug) }}">
                                            <img src="{{ asset($commentUser->avatar ?? 'images/default-avatar.png') }}"
                                                 class="profile-avatar-min"
                                                 alt="{{ $commentUser->name }}">
                                            {{ $commentUser->name }}
                                        </a>
                                      @else
                                        <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                                            <img src="{{ asset($commentUser->avatar ?? 'images/default-avatar.png') }}"
                                                 class="profile-avatar-min"
                                                 alt="{{ $commentUser->name }}">
                                            {{ $commentUser->name }}
                                        </a>
                                      @endif
                                    @else
                                      <a href="#">
                                        <img src="{{ asset('images/default-avatar.png') }}" class="profile-avatar-min" alt="Bilinmeyen Kullanıcı">
                                        Bilinmeyen Kullanıcı
                                      </a>
                                    @endif



                                @auth()
                                        @if($reply->user_id == auth()->user()->id || $reply->idea->user_id == auth()->user()->id)
                                            <a href="{{route('idea.reply.destroy', $reply->id)}}"
                                               class="text-danger"
                                               onclick="return confirm('Yorumu silmek istediğinize emin misiniz ?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        @endif
                                    @endauth
                                </div>

                                <p class="mb-0">{{$reply->content}}</p>

                                <div class="fdrb-box d-flex mt-2 comment-like">
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="like-area @if($reply->like($reply->id)) text-primary @endif"
                                             onclick="likeToggle({{$reply->id}})">
                                            <i class="fa-regular fa-thumbs-up pt-1 me-1"></i>
                                            <span>{{$reply->likes->count()}}</span>
                                        </div>
                                    </form>
                                </div>

                                <div class="fdri-date d-flex">
                                        <span>
                                            {{change_timezone($reply->created_at, 'H:i')}}
                                            {{change_timezone($reply->created_at, 'd.m.Y')}}
                                        </span>
                                </div>
                            </div>
                            
                            {{-- Yanıtları Göster/Gizle --}}
                            @if ($reply->answers->count() > 0)
                                <div class="fikir-detay-yanit-goster-gizle-trigger mb-3" role="button">
                                    - Yanitları Göster
                                </div>
                                <div class="fikir-detay-yanitlari-goster-gizle">
                                    {{-- Eğer yoruma cevaplar varsa --}}
                                    @foreach ($reply->answers as $answer)
                                        <div class="fikir-detay-right-inputs">
                                            <div class="fdri-top d-flex justify-content-between">
                                                @php $answerUser = auth_info($answer->user_id); $answerUserModel = \App\Models\User::find($answer->user_id); @endphp
                                                @if($answerUser && $answerUserModel)
                                                    @if($answerUserModel->user_type === 'company' && $answerUserModel->company)
                                                        <a href="{{ route('companies.show', $answerUserModel->company->slug) }}">
                                                            <img src="{{ asset($answerUser->avatar ?? 'images/default-avatar.png') }}"
                                                                 class="profile-avatar-min"
                                                                 alt="{{ $answerUser->name }}">
                                                            {{ $answerUser->name }}
                                                        </a>
                                                    @else
                                                        <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                                                            <img src="{{ asset($answerUser->avatar ?? 'images/default-avatar.png') }}"
                                                                 class="profile-avatar-min"
                                                                 alt="{{ $answerUser->name }}">
                                                            {{ $answerUser->name }}
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="#">
                                                        <img src="{{ asset('images/default-avatar.png') }}"
                                                             class="profile-avatar-min"
                                                             alt="Bilinmeyen Kullanıcı">
                                                        Bilinmeyen Kullanıcı
                                                    </a>
                                                @endif

                                                @auth()
                                                    @if($answer->user_id == auth()->user()->id || $answer->idea->user_id == auth()->user()->id)
                                                        <a href="{{route('idea.reply.destroy', $answer->id)}}"
                                                           class="text-danger"
                                                           onclick="return confirm('Yorumu silmek istediğinize emin misiniz ?')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>

                                            {{-- Eğer bu yanıt da başka bir yorumu alıntıladıysa --}}
                                            @if ($answer->quotedReply)
                                               <!-- <blockquote>
                                                    <small>{{ $answer->quotedReply->content }}</small>
                                                </blockquote>-->
                                            @endif

                                            <p class="mb-0">{{$answer->content}}</p>

                                            <div class="fdrb-box d-flex mt-2 comment-like">
                                                <form action="" method="POST">
                                                    @csrf
                                                    <div class="like-area @if($answer->like($answer->id)) text-primary @endif"
                                                         onclick="likeToggle({{$answer->id}})">
                                                        <i class="fa-regular fa-thumbs-up pt-1 me-1"></i>
                                                        <span>{{ $answer->likes->count() }}</span>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="fdri-date d-flex">
                                                <span>
                                                    {{change_timezone($answer->created_at, 'H:i')}}
                                                    {{change_timezone($answer->created_at, 'd.m.Y')}}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-3">
                    <p>Henüz yorum yapılmamış</p>
                </div>
            @endif
        </div>
    </div>
</div>
