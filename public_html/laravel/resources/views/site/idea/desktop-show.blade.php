<div class="fikir-detay-box bg-white fikir-detay-width">
  <div class="fikir-detay-left"> @if($idea->path) <div class="fikir-detay-slider">
      <div class="swiper mySwiper9">
        <div class="swiper-wrapper"> @foreach(json_decode($idea->path, true) ?? [] as $path) <div class="swiper-slide">
            <a href="{{asset($path)}}" data-fancybox="gallery" data-caption="Ev Hayaliniz"> @if(get_file_extension($path) != 'mp4') <img src="{{asset($path)}}" style="width: 100%;" alt="Image"> @else <video controls style="width: 100%">
                <source src="{{asset($path)}}" style="width: 100%" />
              </video> @endif </a>
          </div> @endforeach </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div> @endif <div class="fikir-detay-left-text">
      <div class="fikir-bottom-side fikir-detay-paylas fikirdetay-new-title">
        <div class="fikirdetay-new-title-left">
          <div class="d-flex"> @php $user = auth_info($idea->user_id); $ideaUserModel = \App\Models\User::find($idea->user_id); @endphp 
            @if($user && $ideaUserModel) 
              @if($ideaUserModel->user_type === 'company' && $ideaUserModel->company)
                <a href="{{ route('companies.show', $ideaUserModel->company->slug) }}">
                  <img src="{{ asset($user->avatar) }}" class="profile-avatar-min" alt="{{ $user->name }}">
                  {{ $user->name }}
                </a>
              @else
                <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                  <img src="{{ asset($user->avatar) }}" class="profile-avatar-min" alt="{{ $user->name }}">
                  {{ $user->name }}
                </a>
              @endif
            @else 
              <a href="#">
                <img src="{{ asset('default-avatar.png') }}" class="profile-avatar-min" alt="Kullanıcı bulunamadı"> 
                Kullanıcı bulunamadı 
              </a> 
            @endif </div>
        </div>
        <div class="fikirdetay-new-title-right">
          <div class="fbs-left">
            <div class="fbs-boxes @if($idea->ideaLikeExists($idea->id)) liked @endif" onclick="ideaLike('{{$idea->slug}}')">
              <i class="fa-solid fa-heart"></i>
              <span id="desktop-like-count">{{$idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id)}}</span>
            </div>
            <div class="fbs-boxes">
              <a href="#" onclick="document.querySelector('.fdri-boxes') ? document.querySelector('.fdri-boxes').scrollIntoView({behavior: 'smooth'}) : null">
                <i class="fa-solid fa-comment"></i>
                <span id="desktop-comment-count-stats">{{$idea->replies->count()}}</span>
              </a>
            </div>
            <div class="fbs-boxes">
              <i class="fa-solid fa-eye"></i>
              <span id="desktop-view-count">{{$idea->ideaViewCount($idea->id)}}</span>
            </div>
          </div>
          <div class="psd-prices">
            <div class="psd-prices-left">
              <div class="fbs-right">
                <div class="fiyat-gecmisi-trigger fw-normal">
                  <i class="fa-solid fa-share-nodes"></i> Paylaş
                </div>
                <div class="fiyat-gecmisi-area copy-area" style="">
                  <div class="fiyat-gecmisi-giris">
                    <div class="fiyat-gecmisi-close">
                      <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <a href="javascript:void(0)" class="share-btn fw-normal" data-url="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/idea/arsa-secerken-dikkat-etmeni-69" onclick="copyToClipboard(this)">
                      <i class="fa-solid fa-share-nodes me-2 pt-1"></i> Kopyala </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p class="mb-0" style="white-space: pre-line">{{$idea->content}}</p>
    </div>
  </div>
  <div class="fikir-detay-right">
    <div class="fikir-detay-right-form">
      <div class="fikir-detay-right-box"> @if($mostLikedReply) <h5 style="font-size: 15px !important">En Çok Beğeni Alan Yorum</h5>
        <div class="fdri-boxes">
          <div class="fikir-detay-right-inputs">
            <div class="fdri-top d-flex">
              @php 
                $mostLikedUser = auth_info($mostLikedReply->user_id);
                $mostLikedUserModel = \App\Models\User::find($mostLikedReply->user_id);
              @endphp
              @if($mostLikedUser && $mostLikedUserModel)
                @if($mostLikedUserModel->user_type === 'company' && $mostLikedUserModel->company)
                  <a href="{{ route('companies.show', $mostLikedUserModel->company->slug) }}">
                    <img src="{{asset($mostLikedUser->avatar)}}" class="profile-avatar-min" alt="{{$mostLikedUser->name}}">
                    {{$mostLikedUser->name}}
                  </a>
                @else
                  <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                    <img src="{{asset($mostLikedUser->avatar)}}" class="profile-avatar-min" alt="{{$mostLikedUser->name}}">
                    {{$mostLikedUser->name}}
                  </a>
                @endif
              @else
                <img src="{{ asset('default-avatar.png') }}" class="profile-avatar-min" alt="Bilinmeyen Kullanıcı">
                Bilinmeyen Kullanıcı
              @endif
            </div>
            {{-- $mostLikedReply bu yanıt da başka bir yorumu alıntıladıysa --}} @if ($mostLikedReply->quotedReply) <blockquote>
              <small>{{ $mostLikedReply->quotedReply->content }}</small>
            </blockquote> @endif <p class="mb-0">
              {{$mostLikedReply->content}}
            </p>
            <div class="fdrb-box d-flex mt-2 comment-like">
              <form action="" method="POST"> @csrf <div class="like-area @if($mostLikedReply->like($mostLikedReply->id)) text-primary @endif" onclick="likeToggle({{$mostLikedReply->id}})">
                  <i class="fa-regular fa-thumbs-up pt-1 me-1"></i>
                  <span>{{$mostLikedReply->likes->count()}}</span>
                </div>
              </form>
            </div>
            <div class="fdri-date d-flex">
              <span>
                {{change_timezone($mostLikedReply->created_at, 'H:i')}}
                {{change_timezone($mostLikedReply->created_at, 'd.m.Y')}}
              </span>
            </div>
          </div>
        </div> @endif <div class="d-flex align-items-center justify-content-between">
          <h5 class="mt-4 me-3" style="font-size: 15px !important">Yorumlar (<span id="comment-count">{{$idea->replies->count()}}</span>)</h5>
          <form action="" method="GET">
            <select name="sort_by" class="form-select" onchange="this.closest('form').submit()">
              <option value="new" @selected(request()->sort_by == 'new')>En Yeni </option>
              <option value="like" @selected(request()->sort_by == 'like')>En Beğenilen </option>
            </select>
          </form>
        </div> @foreach($replies as $reply) <div class="fdri-boxes">
          <div class="fikir-detay-right-inputs">
            <div class="fdri-top d-flex justify-content-between"> @php $replyUser = auth_info($reply->user_id); @endphp 
                @if($replyUser)
                  @php $user = \App\Models\User::find($reply->user_id); @endphp
                  @if($user && $user->user_type === 'company' && $user->company)
                    <a href="{{ route('companies.show', $user->company->slug) }}">
                      <img src="{{ asset($replyUser->avatar ?? 'default-avatar.png') }}" class="profile-avatar-min" alt="{{ $replyUser->name }}">
                      {{ $replyUser->name }}
                    </a>
                  @else
                    <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                      <img src="{{ asset($replyUser->avatar ?? 'default-avatar.png') }}" class="profile-avatar-min" alt="{{ $replyUser->name }}">
                      {{ $replyUser->name }}
                    </a>
                  @endif
                @else
                  <a href="#">
                    <img src="{{ asset('default-avatar.png') }}" class="profile-avatar-min" alt="Bilinmeyen Kullanıcı">
                    Bilinmeyen Kullanıcı
                  </a>
                @endif @auth() @if($reply->user_id == auth()->user()->id || $reply->idea->user_id == auth()->user()->id) <a href="{{route('idea.reply.destroy', $reply->id)}}" class="text-danger" onclick="return confirm('Yorumu silmek istediğinize emin misiniz ?')">
                <i class="fa-solid fa-trash"></i>
              </a> @endif @endauth </div>
            <p class="mb-0">{{$reply->content}}</p>
            <div class="fdrb-box d-flex mt-2 comment-like">
              <form action="" method="POST"> @csrf <div class="like-area @if($reply->like($reply->id)) text-primary @endif" onclick="likeToggle({{$reply->id}})">
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
          <div class="fikir-detay-answer-trigger"> Yanıtla </div>
          <div class="fikir-detay-yanitla"> @auth() <form action="{{route('idea.reply.store')}}" method="POST">
              <div class="form-group">
                <div class="input-field">
                  <input type="text" name="content" required="">
                  <label>Yanıtla</label>
                  <input type="hidden" name="idea_id" value="{{$idea->id}}"> @if(isset($reply)) <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}"> @endif <input type="hidden" name="quoted_reply_id" value="{{$reply->id}}">
                </div>
              </div> @csrf <div class="text-right">
                <button type="submit">Gönder</button>
              </div>
            </form> @endauth @guest() <b class="d-block text-center"> Yorum yapmak için lütfen <span class="text-blue-600" data-bs-toggle="modal" href="#exampleModalToggle" style="cursor: pointer;">giriş yapın.</span>
            </b> @endguest </div> @if ($reply->answers->count() > 0) <div class="fikir-detay-yanit-goster-gizle-trigger mb-3" role="button"> - Yanitları Göster </div>
          <div class="fikir-detay-yanitlari-goster-gizle">
            {{-- Eğer yoruma cevaplar varsa --}} @foreach ($reply->answers as $answer) <div class="fikir-detay-right-inputs">
              <div class="fdri-top d-flex">
                @php $answerUser = auth_info($answer->user_id); $answerUserModel = \App\Models\User::find($answer->user_id); @endphp
                @if($answerUser && $answerUserModel)
                  @if($answerUserModel->user_type === 'company' && $answerUserModel->company)
                    <a href="{{ route('companies.show', $answerUserModel->company->slug) }}">
                      <img src="{{ asset($answerUser->avatar) }}" class="profile-avatar-min" alt="{{ $answerUser->name }}">
                      {{ $answerUser->name }}
                    </a>
                  @else
                    <a href="#" onclick="alert('Kullanıcı profil sayfası yakında eklenecek!')">
                      <img src="{{ asset($answerUser->avatar) }}" class="profile-avatar-min" alt="{{ $answerUser->name }}">
                      {{ $answerUser->name }}
                    </a>
                  @endif
                @else
                  <img src="{{ asset('default-avatar.png') }}" class="profile-avatar-min" alt="Bilinmeyen Kullanıcı">
                  Bilinmeyen Kullanıcı
                @endif
              </div>
              {{-- Eğer bu yanıt da başka bir yorumu alıntıladıysa --}} @if ($answer->quotedReply)   <!--  <blockquote>
            <small>{{-- $answer->quotedReply->content --}} </small>
              </blockquote> --> @endif <p class="mb-0">
                {{ $answer->content }}
              </p>
              <div class="fdrb-box d-flex mt-2 comment-like">
                <form action="" method="POST"> @csrf <div class="like-area @if($answer->like($answer->id)) text-primary @endif" onclick="likeToggle({{ $answer->id }})">
                    <i class="fa-regular fa-thumbs-up pt-1 me-1"></i>
                    <span>{{ $answer->likes->count() }}</span>
                  </div>
                </form>
              </div>
              <div class="fdri-date d-flex">
                <span>
                  {{ change_timezone($answer->created_at, 'H:i') }}
                  {{ change_timezone($answer->created_at, 'd.m.Y') }}
                </span>
              </div>
            </div>
            <div class="fikir-detay-answer-trigger">Yanıtla</div>
            <div class="fikir-detay-yanitla"> @auth <form action="{{ route('idea.reply.store') }}" method="POST"> @csrf <div class="form-group">
                  <div class="input-field">
                    <input type="text" name="content" required="">
                    <label>Yanıtla</label>
                    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                    <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}">
                    <input type="hidden" name="quoted_reply_id" value="{{ $answer->id }}">
                  </div>
                </div>
                <div class="text-right">
                  <button type="submit">Gönder</button>
                </div>
              </form> @endauth @guest <b class="d-block text-center"> Yorum yapmak için lütfen <span class="text-blue-600" data-bs-toggle="modal" href="#exampleModalToggle" style="cursor: pointer;">giriş yapın.</span>
              </b> @endguest </div> @endforeach
          </div> @endif
        </div> @endforeach
      </div>
      <div class="fikir-detay-right-bottom">
        {{-- <div class="fdrb-date d-flex">--}}
        {{-- <span>--}}
        {{-- ÖS 19:32--}}
        {{-- </span>--}}
        {{-- <span>--}}
        {{-- 23.12.2024--}}
        {{-- </span>--}}
        {{-- </div>--}}
        {{-- --}}
        {{-- <div class="fdrb-icons d-flex">--}}
        {{-- <div class="fdrb-box d-flex">--}}
        {{-- <i class="fa-regular fa-comment"></i>--}}
        {{-- <span>--}}
        {{-- 26--}}
        {{-- </span>--}}
        {{-- </div>--}}
        {{-- <div class="fdrb-box d-flex">--}}
        {{-- <i class="fa-regular fa-thumbs-up"></i>--}}
        {{-- <span>--}}
        {{-- 126--}}
        {{-- </span>--}}
        {{-- </div>--}}
        {{-- <div class="fdrb-box d-flex">--}}
        {{-- <i class="fa-regular fa-paper-plane"></i>--}}
        {{-- <span>--}}
        {{-- 35--}}
        {{-- </span>--}}
        {{-- </div>--}}
        {{-- <div class="fdrb-box d-flex">--}}
        {{-- <i class="fa-regular fa-eye"></i>--}}
        {{-- <span>--}}
        {{-- 355--}}
        {{-- </span>--}}
        {{-- </div>--}}
        {{-- </div>--}}
        <div class="fdbr-textarea bg-white" @guest() style="box-shadow: none" @endguest> @auth() <form action="{{route('idea.reply.store')}}" method="POST">
            <textarea name="content" placeholder="Yorumunuzu yazın..." required>{{old('content')}}</textarea>
            <input type="hidden" name="idea_id" value="{{$idea->id}}"> @csrf <button type="submit">Paylaş</button>
          </form> @endauth @guest() <b class="d-block text-center"> Yorum yapmak için lütfen <a href="#" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">giriş yapın.</a>
          </b> @endguest </div>
      </div>
    </div>
  </div>
</div>