@extends('site.inc.master') @section('css') <style>
  .main.sidebar {
    padding-left: 0;
  }

  .plus {
    display: none;
  }

  .hdzb-left {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .hdzb-mobil-top {
    background-color: #000 !important;
  }

  .hdzb-slider {
    display: flex;
    gap: 15px;
    align-items: flex-start;
  }

  .main-slider {
    width: calc(100% - 160px);
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .main-slider .swiper-slide {
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .main-slider .swiper-slide img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    display: block;
    margin: auto;
  }

  .thumb-slider-vertical {
    width: 150px;
    max-height: 500px;
  }

  .thumb-slider-vertical .swiper-wrapper {
    flex-direction: column;
  }

  .thumb-slider-vertical .swiper-slide {
    width: 100% !important;
    height: auto !important;
    margin-bottom: 10px;
    opacity: 0.4;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .thumb-slider-vertical .swiper-slide-thumb-active {
    opacity: 1;
  }

  .thumb-slider-vertical img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 4px;
  }

  @media screen and (max-width: 991px) {
    .hdzb-slider {
      flex-direction: column;
    }

    .main-slider,
    .thumb-slider-vertical {
      width: 100%;
      height: auto;
    }

    .thumb-slider-vertical .swiper-wrapper {
      flex-direction: row;
      flex-wrap: nowrap;
    }

    .thumb-slider-vertical .swiper-slide {
      margin-right: 10px;
      margin-bottom: 0;
    }
  }

  @media (max-width: 768px) {
    .fiyat-gecmisi-area {
      position: fixed !important;
      top: 50%;
      left: 50%;
      right: 2rem;
      transform: translate(-50%, -50%);
      width: calc(95vw - 80px);
      /* sağ-sol 20px boşluk bırakarak ortalar */
      max-width: 400px;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
      z-index: 99999;
      display: none;
      overflow-y: auto;
      box-sizing: border-box;
    }

    .fiyat-gecmisi-area.active {
      display: block !important;
    }
  }

  /* İletişim Bilgileri Popup Stilleri */
  .iletisim-popup {
    position: fixed;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1050;
    min-width: 280px;
    max-width: 350px;
    overflow: hidden;
  }

  .iletisim-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
  }

  .iletisim-popup-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #212529;
  }

  .iletisim-popup-close {
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
  }

  .iletisim-popup-close:hover {
    color: #212529;
  }

  .iletisim-popup-body {
    padding: 16px;
    text-align: center;
  }

  @media (max-width: 768px) {
    .iletisim-popup {
      min-width: 250px;
      max-width: 300px;
    }
  }
</style> @endsection @section('content') <div class="main sidebar">
  <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
    <div class="index-right hizmet-detay-ziyaretci">
      <div class="hizmet-detay-ziyaretci-box hdzb-web-box">
        <div class="hdzb-left bg-white p-3">
          <div class="hdzb-title d-flex">
            <h1 class="text-truncate">
              {{$service->title}}
            </h1>
            <div class="hdzb-price">
              <div class="psd-prices-left d-flex">
                <x-old-prices :prices="$service->oldPrices" />
                <span style="margin-left: 10px;">
                  {{ number_format($service->price, 0, ',', '.') }}TL </span>
              </div>
            </div>
          </div>
          <div class="hdzb-slider">
            <!-- Ana büyük slider -->
            <div class="swiper mySwiper7 main-slider">
              <div class="swiper-wrapper"> @foreach($service->photos as $photo) <div class="swiper-slide">
                  <a href="{{ asset($photo->path) }}" data-fancybox="gallery" data-caption="Ev Hayaliniz">
                    <img src="{{ asset($photo->path) }}" />
                  </a>
                </div> @endforeach </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
            <!-- Sağda dikey küçük resimler -->
            <div thumbsSlider="" class="swiper mySwiper6 thumb-slider-vertical">
              <div class="swiper-wrapper"> @foreach($service->photos as $photo) <div class="swiper-slide">
                  <img src="{{ asset($photo->path) }}" />
                </div> @endforeach </div>
            </div>
          </div>
        </div>
        <div class="hdzb-right">
          <div class="hdzb-right-box">
            <div class="hdzb-img">
              <a href="#">
                <img src="{{asset($service->company->avatar)}}" alt="{{$service->company->name}}" style="width: 150px; height: 150px">
              </a>
            </div>
            <div class="hdzb-right-title">
              <a href="{{route('companies.show', $service->company->slug)}}" style="font-weight: 600;">
                {{$service->company->name}}
              </a> @if($service->company->is_verified == 1) <img src="{{asset('site/images/success.png')}}" alt="Verified"> @endif
            </div>
            <div class="hdzb-right-links">
              <ul>
                <li>
                  <a href="{{route('companies.show', $service->company->slug)}}">Tüm Hizmetler</a>
                </li> @auth() @if(auth()->user()->id != $service->company->user_id) <li>
                  <form action="{{route('company.follow')}}" method="POST">
                    <a href="#" onclick="this.closest('form').submit()"> @if(!auth()->user()->following($service->company->user_id)) Takip Et @else Takipten Çık @endif </a>
                    <input type="hidden" name="user" value="{{\Illuminate\Support\Facades\Crypt::encryptString($service->company->user_id)}}"> @csrf
                  </form>
                </li> @endif @endauth
              </ul>
            </div>
            <div class="hzdb-right-links-bottom">
              <ul>
                <li>
                  <a class="button-primary button" @auth() href="{{route('chat.show', $service->company->user_id)}}" @endauth @guest() data-bs-toggle="modal" href="#exampleModalToggle" @endguest> Mesaj </a>
                </li>
                <li>
                  <a class="btn btn-outline-primary button-outline button ara-button" href="javascript:void(0)" onclick="showIletisimPopup(this)"> Ara </a>
                </li>
              </ul>
            </div> @auth() <div class="hzdb-right-shares">
              <div>
                <a href="javascript:void(0)" class="share-btn share-svg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                    <path fill="currentColor" d="M17 22q-1.25 0-2.125-.875T14 19q0-.15.075-.7L7.05 14.2q-.4.375-.925.588T5 15q-1.25 0-2.125-.875T2 12t.875-2.125T5 9q.6 0 1.125.213t.925.587l7.025-4.1q-.05-.175-.062-.337T14 5q0-1.25.875-2.125T17 2t2.125.875T20 5t-.875 2.125T17 8q-.6 0-1.125-.213T14.95 7.2l-7.025 4.1q.05.175.063.338T8 12t-.012.363t-.063.337l7.025 4.1q.4-.375.925-.587T17 16q1.25 0 2.125.875T20 19t-.875 2.125T17 22m0-2q.425 0 .713-.287T18 19t-.288-.712T17 18t-.712.288T16 19t.288.713T17 20M5 13q.425 0 .713-.288T6 12t-.288-.712T5 11t-.712.288T4 12t.288.713T5 13m12-7q.425 0 .713-.288T18 5t-.288-.712T17 4t-.712.288T16 5t.288.713T17 6m0-1" />
                  </svg>
                </a>
              </div>
              <div>
                @auth
                <a href="{{route('services.save', $service->slug)}}" class="text-dark"> @if(\App\Models\ServiceSaved::where('user_id', auth()->user()->id) ->where('service_id', $service->id)->first()) <i class="fa-solid fa-bookmark"></i> @else <i class="fa-regular fa-bookmark"></i> @endif </a>
                @else
                <a href="javascript:void(0)" class="text-dark" onclick="showLoginPopup('Kaydetmek için giriş yapmalısınız!', this)"> <i class="fa-regular fa-bookmark"></i> </a>
                @endauth
              </div>
            </div>
            <div class="hdzb-right-sikayet">
              <div class="firma-sikayeti-button">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#firmasikayeti"> Hizmet ile ilgili şikayetim var! </button>
              </div>
            </div> @endauth
          </div>
        </div>
      </div>
      <div class="hdzb-mobil-box">
        <div class="hdzb-mobil-top">
          <div class="swiper mySwiper8">
            <div class="swiper-wrapper"> @foreach($service->photos as $photo) <div class="swiper-slide">
                <div class="hdz-mobil-img">
                  <a class="hdz-mobil-fancy" href="{{ asset($photo->path) }}" data-fancybox="gallery" data-caption="Ev Hayaliniz">
                    <img src="{{ asset($photo->path) }}" class="responsive-img" />
                  </a>
                </div>
              </div> @endforeach </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="d-flex">
            <div class="hdzb-mobil-top-left">
              <a href="#" onclick="history.back(); return false;">
                <i class="fa-solid fa-arrow-left"></i>
              </a>
              <a href="{{route('services.index', ['category' => $service->category_id, 'sub_category' => $service->sub_category_id])}}">
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
              @auth
              <a href="{{route('services.save', $service->slug)}}"> @if(\App\Models\ServiceSaved::where('user_id', auth()->user()->id) ->where('service_id', $service->id)->first()) <i class="fa-solid fa-bookmark"></i> @else <i class="fa-regular fa-bookmark"></i> @endif </a>
              @else
              <a href="javascript:void(0)" onclick="showLoginPopup('Kaydetmek için giriş yapmalısınız!', this)"> <i class="fa-regular fa-bookmark"></i> </a>
              @endauth
            </div>
          </div>
        </div>
        <div class="hdzb-mobil-texts eplan-mobil-texts">
          <div class="eplan-mobil-texts-title">
            <div class="eplan-mtt-left">
              <h3 class="text-truncate"> {{$service->title}}</h3>
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
          <ul class="nav nav-tabs" id="eplanmobiltab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab1" data-bs-toggle="tab" data-bs-target="#home-tab1-pane" type="button" role="tab" aria-controls="home-tab1-pane" aria-selected="true"> Açıklama </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile5-tab" data-bs-toggle="tab" data-bs-target="#profile5-tab-pane" type="button" role="tab" aria-controls="profile5-tab-pane" aria-selected="false"> Özellikler </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab1" data-bs-toggle="tab" data-bs-target="#contact-tab1-pane" type="button" role="tab" aria-controls="contact-tab1-pane" aria-selected="false"> Soru Sor </button>
            </li>
          </ul>
          <div class="tab-content" id="eplanmobiltab Content">
            <div class="tab-pane fade show active" id="home-tab1-pane" role="tabpanel" aria-labelledby="home-tab1" tabindex="0">
              <div class="hizmet-hakkinda-aciklama hdzb-mobil-aciklama">
                <div>
                  <p>{{$service->description}}
                    <span class="hdzm-mobil-hizmet more-hizmet2 ms-3">Daha Az</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile5-tab-pane" role="tabpanel" aria-labelledby="profile5-tab" tabindex="0">
              <div class="eplan-ozellikler-web eplanozellikler-mobil">
                <!-- Dinamik Özellikler -->
                @if($service->parameterValues->count() > 0)
                @foreach($service->parameterValues as $index => $parameterValue)
                <div class="eplan-ozelliklerbox {{ $index % 2 == 0 ? 'colorless' : '' }}">
                  <b> {{ $parameterValue->categoryParameter->title }}: </b>
                  <span> {{ $parameterValue->value }} </span>
                </div>
                @endforeach
                <!-- Kategori ve Konum bilgileri -->
                <div class="eplan-ozelliklerbox {{ $service->parameterValues->count() % 2 == 0 ? 'colorless' : '' }}">
                  <b> Kategori: </b>
                  <span> {{ $service->category->name ?? 'Belirtilmemiş' }} / {{ $service->subCategory->name ?? 'Belirtilmemiş' }} </span>
                </div>
                <div class="eplan-ozelliklerbox {{ ($service->parameterValues->count() + 1) % 2 == 0 ? 'colorless' : '' }}">
                  <b> Konum: </b>
                  <span> {{ $service->province->name ?? 'Belirtilmemiş' }} / {{ $service->district->name ?? 'Belirtilmemiş' }} </span>
                </div>
                @else
                <!-- Varsayılan özellikler eğer dinamik parametre yoksa -->
                <div class="eplan-ozelliklerbox colorless">
                  <b> Metrekare: </b>
                  <span> {{ $service->sqm }} m² </span>
                </div>
                <div class="eplan-ozelliklerbox">
                  <b> Oda Sayısı: </b>
                  <span> {{ $service->rooms }} </span>
                </div>
                <div class="eplan-ozelliklerbox colorless">
                  <b> Kategori: </b>
                  <span> {{ $service->category->name ?? 'Belirtilmemiş' }} / {{ $service->subCategory->name ?? 'Belirtilmemiş' }} </span>
                </div>
                <div class="eplan-ozelliklerbox">
                  <b> Konum: </b>
                  <span> {{ $service->province->name ?? 'Belirtilmemiş' }} / {{ $service->district->name ?? 'Belirtilmemiş' }} </span>
                </div>
                @endif
              </div>
            </div>
            <div class="tab-pane fade" id="contact-tab1-pane" role="tabpanel" aria-labelledby="contact-tab1" tabindex="0">
              <div class="tab-bg"> @auth() @if(auth()->user()->user_type == 'company' && auth()->user()->company->id != $service->company_id || auth()->user()->user_type == 'user') <form action="{{route('services.question', $service->slug)}}" method="POST">
                  <div class="px-3">
                    <div class="sorular-input">
                      <textarea name="question" rows="4" placeholder="Soru Sor" class="w-100 mt-0" style="padding: 15px" maxlength="1900" required>{{old('question')}}</textarea>
                    </div> @csrf <div class="sorular-cevap ">
                      <button class="button-primary button" type="submit">Gönder</button>
                    </div>
                  </div>
                </form> @endif @else
                <!-- Guest user login prompt -->
                <div class="px-3">
                  <div style="padding: 20px; cursor: pointer;" onclick="openLoginModal()">
                    <span style="color: #666; font-size: 14px;">Soru sormak için lütfen <span style="color: #4068e2;">giriş yapın</span>
                    </span>
                  </div>
                </div> @endauth <div class="d-flex"> @foreach($questions as $question) <div class="sorular-box w-50">
                    <div class="sorular-title d-flex">
                      <div class="sorular-title-left">
                        <img src="{{asset(auth_info($question->user_id)->avatar)}}" class="profile-avatar-min" alt="{{auth_info($question->user_id)->name}}">
                        <span>
                          {{auth_info($question->user_id)->name}}
                        </span>
                      </div> @if(auth()->check() && auth()->user()->user_type == 'company' && $service->company_id == auth()->user()->company->id || auth()->check() && auth()->user()->id == $question->user_id) <form action="{{route('services.question.destroy', [$service->slug, $question->id])}}" method="POST" onsubmit="return confirm('Bu soruyu silmek istediğinize emin misiniz?');"> @method('DELETE') @csrf <div class="sorular-title-right">
                          <button type="submit">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
                      </form> @endif
                    </div>
                    <div class="sorular-text">
                      <p>
                        {{$question->question}}
                      </p>
                    </div>
                    <div class="sorular-time">
                      <span>
                        {{change_timezone($question->created_at, 'H:i')}}
                      </span>
                      <span>
                        {{change_timezone($question->created_at, 'd.m.Y')}}
                      </span>
                    </div> @if($question->answer) <div class="question-answer-box">
                      <div class="sorular-text">
                        <b>Cevap:</b>
                        <p>
                          {{$question->answer}}
                        </p>
                      </div>
                    </div> @endif @if(auth()->check() && auth()->user()->user_type == 'company' && $service->company_id == auth()->user()->company->id) <form action="{{route('services.answer', $service->slug)}}" method="POST">
                      <div class="sorular-input">
                        <div class="text-area-head d-flex">
                          <img src="{{asset(auth_info()->avatar)}}" alt="{{auth_info()->name}}">
                          <b>{{auth_info()->name}}</b>
                        </div>
                        <input name="question" type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encryptString($question->id)}}">
                        <textarea name="answer" rows="4" cols="50" placeholder="Cevap ver..." required>{{old('answer', $question->answer)}}</textarea>
                      </div> @csrf <div class="sorular-cevap">
                        <button type="submit">{{!$question->answer ? 'Cevapla' : 'Cevabı Güncelle'}}</button>
                      </div>
                    </form> @endif
                  </div> @endforeach </div>
                {{$questions->links()}}
              </div>
            </div>
          </div>
          <div class="hdzb-mobil-list hdzb-mobil-list-blocks">
            <div class="hdzb-mobil-list-box">
              <a href="{{route('companies.show', $service->company->slug)}}">
                <b>
                  {{$service->company->name}}
                </b>
              </a>
            </div> @foreach($service->parameterValues as $parameterValue) <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2">
                {{ $parameterValue->categoryParameter->title }}: {{ $parameterValue->value }}
              </span>
            </div> @endforeach <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2">
                {{$service?->category?->name . '/' . $service?->subCategory?->name}}
              </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2">
                {{$service?->province?->name . '/' . $service?->district?->name}}
              </span>
            </div>
          </div>
        </div>
        <div class="hdzb-mobil-trigger-box w-100 hdzb-mobil-trigger">
          <h5 class="text-truncate">
            {{$service->title}}
          </h5>
          <div class="d-flex">
            <p>
              {{$service->description}}
            </p>
            <div class="hdzb-mobil-trigger-text"> daha fazla </div>
          </div>
          <div class="hdzb-mobil-list">
            <div>
              <a href="{{route('companies.show', $service->company->slug)}}" class="hdzb-mobil-list-box">
                <b>
                  {{$service->company->name}}
                </b>
              </a>
            </div> @foreach($service->parameterValues as $parameterValue) <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2">
                {{ $parameterValue->categoryParameter->title }}: {{ $parameterValue->value }}
              </span>
            </div> @endforeach <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2">
                {{$service?->category?->name . '/' . $service?->subCategory?->name}}
              </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2">
                {{$service?->province?->name . '/' . $service?->district?->name}}
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="hdzb-mobil-bottom">
        <div class="hdzb-mobil-flex">
          <div class="hdzb-mobil-bottom-left">
            <a class="btn btn-outline-primary button-outline button ara-button" href="javascript:void(0)" onclick="showIletisimPopup(this)"> Ara </a>
            <a class="button-primary button" @auth() href="{{route('chat.show', $service->company->user_id)}}" @endauth @guest() data-bs-toggle="modal" href="#exampleModalToggle" @endguest> Mesaj </a>
          </div>
          <div class="hdzb-mobil-bottom-right">
            <div class="psd-prices">
              <div class="psd-prices-left">
                <div class="psd-prices-left">
                  <x-old-prices :prices="$service->oldPrices" />
                  <span>
                    {{ number_format($service->price, 0, ',', '.') }} TL </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="firma-tabs-area hizmet-detay-tabs-area">
        <div class="firma-tabs-box d-none d-lg-block">
          <ul class="nav nav-tabs firma-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Açıklama </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Soru Sor </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile1-tab" data-bs-toggle="tab" data-bs-target="#profile1" type="button" role="tab" aria-controls="profile1" aria-selected="false">Özellikler </button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="container-fluid firma-services-tab">
                <div class="row">
                  <div class="hizmet-hakkinda-aciklama">
                    <div class="hdzb-mobil-list hizmet-hakkida-aciklama-2"> @foreach($service->parameterValues as $parameterValue) <div class="hdzb-mobil-list-box">
                        <span>{{ $parameterValue->categoryParameter->title }} : </span>
                        <span class="fw-normal d-inline-block ms-2">
                          {{ $parameterValue->value }}
                        </span>
                      </div> @endforeach <div class="hdzb-mobil-list-box">
                        <span>Kategori : </span>
                        <span class="fw-normal d-inline-block ms-2">
                          {{$service?->category?->name . '/' . $service?->subCategory?->name}}
                        </span>
                      </div>
                      <div class="hdzb-mobil-list-box">
                        <span>Konum : </span>
                        <span class="fw-normal d-inline-block ms-2">
                          {{$service?->province?->name . '/' . $service?->district?->name}}
                        </span>
                      </div>
                    </div>
                    <p class="mt-3 h-100 overflow-y-auto text-break">
                      {{$service->description}}
                    </p>
                  </div>
                  {{-- <div class="more-hizmet">Daha Fazla</div>--}}
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="tab-bg"> @auth() @if(auth()->user()->user_type == 'company' && auth()->user()->company->id != $service->company_id || auth()->user()->user_type == 'user') <form action="{{route('services.question', $service->slug)}}" method="POST">
                  <div class="px-3">
                    <div class="sorular-input">
                      <textarea name="question" rows="4" placeholder="Soru Sor" class="w-100 mt-0" style="padding: 15px" maxlength="1900" required>{{old('question')}}</textarea>
                    </div> @csrf <div class="sorular-cevap hizmetdetaysendbutton">
                      <button class="button-primary button" type="submit">Gönder</button>
                    </div>
                  </div>
                </form> @endif @else
                <!-- Guest user login prompt -->
                <div class="px-3">
                  <div style="padding: 20px; cursor: pointer;" onclick="openLoginModal()">
                    <span style="color: #666; font-size: 14px;">Soru sormak için lütfen <span style="color: #4068e2;">giriş yapın</span>
                    </span>
                  </div>
                </div> @endauth <div class="d-flex"> @foreach($questions as $question) <div class="sorular-box w-50">
                    <div class="sorular-title d-flex">
                      <div class="sorular-title-left">
                        <img src="{{asset(auth_info($question->user_id)->avatar)}}" class="profile-avatar-min" alt="{{auth_info($question->user_id)->name}}">
                        <span>
                          {{auth_info($question->user_id)->name}}
                        </span>
                      </div> @if(auth()->check() && auth()->user()->user_type == 'company' && $service->company_id == auth()->user()->company->id || auth()->check() && auth()->user()->id == $question->user_id) <form action="{{route('services.question.destroy', [$service->slug, $question->id])}}" method="POST" onsubmit="return confirm('Bu soruyu silmek istediğinize emin misiniz?');"> @method('DELETE') @csrf <div class="sorular-title-right">
                          <button type="submit">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </div>
                      </form> @endif
                    </div>
                    <div class="sorular-text">
                      <p>
                        {{$question->question}}
                      </p>
                    </div>
                    <div class="sorular-time">
                      <span>
                        {{change_timezone($question->created_at, 'H:i')}}
                      </span>
                      <span>
                        {{change_timezone($question->created_at, 'd.m.Y')}}
                      </span>
                    </div> @if($question->answer) <div class="question-answer-box">
                      <div class="sorular-text">
                        <b>Cevap:</b>
                        <p>
                          {{$question->answer}}
                        </p>
                      </div>
                    </div> @endif @if(auth()->check() && auth()->user()->user_type == 'company' && $service->company_id == auth()->user()->company->id) <form action="{{route('services.answer', $service->slug)}}" method="POST">
                      <div class="sorular-input">
                        <div class="text-area-head d-flex">
                          <img src="{{asset(auth_info()->avatar)}}" alt="{{auth_info()->name}}">
                          <b>{{auth_info()->name}}</b>
                        </div>
                        <input name="question" type="hidden" value="{{\Illuminate\Support\Facades\Crypt::encryptString($question->id)}}">
                        <textarea name="answer" rows="4" cols="50" placeholder="Cevap ver..." required>{{old('answer', $question->answer)}}</textarea>
                      </div> @csrf <div class="sorular-cevap">
                        <button type="submit">{{!$question->answer ? 'Cevapla' : 'Cevabı Güncelle'}}</button>
                      </div>
                    </form> @endif
                  </div> @endforeach </div>
                {{$questions->links()}}
              </div>
            </div>
            <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile1-tab">
              <div class="tab-bg">
                <div class="eplan-ozellikler-web">
                  <!-- Desktop Dinamik Özellikler -->
                  @if($service->parameterValues->count() > 0)
                  @foreach($service->parameterValues as $index => $parameterValue)
                  <div class="eplan-ozelliklerbox {{ $index % 2 == 0 ? 'colorless' : '' }}">
                    <b> {{ $parameterValue->categoryParameter->title }}: </b>
                    <span> {{ $parameterValue->value }} </span>
                  </div>
                  @endforeach
                  <!-- Kategori ve Konum bilgileri -->
                  <div class="eplan-ozelliklerbox {{ $service->parameterValues->count() % 2 == 0 ? 'colorless' : '' }}">
                    <b> Kategori: </b>
                    <span> {{ $service->category->name ?? 'Belirtilmemiş' }} / {{ $service->subCategory->name ?? 'Belirtilmemiş' }} </span>
                  </div>
                  <div class="eplan-ozelliklerbox {{ ($service->parameterValues->count() + 1) % 2 == 0 ? 'colorless' : '' }}">
                    <b> Konum: </b>
                    <span> {{ $service->province->name ?? 'Belirtilmemiş' }} / {{ $service->district->name ?? 'Belirtilmemiş' }} </span>
                  </div>
                  @else
                  <!-- Varsayılan özellikler eğer dinamik parametre yoksa -->
                  <div class="eplan-ozelliklerbox colorless">
                    <b> Metrekare: </b>
                    <span> {{ $service->sqm }} m² </span>
                  </div>
                  <div class="eplan-ozelliklerbox">
                    <b> Oda Sayısı: </b>
                    <span> {{ $service->rooms }} </span>
                  </div>
                  <div class="eplan-ozelliklerbox colorless">
                    <b> Kategori: </b>
                    <span> {{ $service->category->name ?? 'Belirtilmemiş' }} / {{ $service->subCategory->name ?? 'Belirtilmemiş' }} </span>
                  </div>
                  <div class="eplan-ozelliklerbox">
                    <b> Konum: </b>
                    <span> {{ $service->province->name ?? 'Belirtilmemiş' }} / {{ $service->district->name ?? 'Belirtilmemiş' }} </span>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="other-hizmets">
        <div class="popular-services">
          <div class="cs-title d-flex cs-title-link">
            <div class="ctl-left">
              <i class="fa-solid fa-business-time"></i>
              <h2> Benzer Hizmetler </h2>
            </div>
            <div class="ctl-right">
              <a href="{{route('services.index')}}"> Tüm Hizmetler <i class="fa-solid fa-angle-right"></i>
              </a>
            </div>
          </div>
          <div class="popular-slider hizmetdetayslider">
            <div class="swiper mySwiper3">
              <div class="swiper-wrapper">
                <!-- en üst swiper-slide referans alınacak full hali o diğerlerini silebilirsin en üsttekini mutlaka almalısın --> @foreach($similarServices as $similarService) <div class="swiper-slide">
                  <div class="popular-services-cards">
                    <div class="psc-img">
                      <a href="{{route('services.show', $similarService->slug)}}">
                        <img src="{{asset($similarService->photos->first()['path'] ?? null)}}" alt="{{$similarService->title}}">
                      </a>
                    </div>
                    <div class="psd-texts">
                      <h3>
                        <a href="{{route('services.show', $similarService->slug)}}">{{$similarService->title}}</a>
                      </h3>
                      <div class="psd-texts-icons">
                        <div class="pti-area">
                          <i class="fa-solid fa-tag"></i>
                          <span> {{$similarService?->category?->name . ' / ' . $similarService?->subCategory?->name}} </span>
                        </div>
                        <div class="pti-area">
                          <i class="fa-solid fa-location-dot"></i>
                          <span>
                            {{$similarService->province->name . ' / ' . $similarService->district->name}}
                          </span>
                        </div>
                      </div>
                      {{-- <p class="mb-0">{{str()->limit($service->description, 100)}}</p>--}} <div class="psd-firma">
                        <a href="{{route('companies.show', $similarService->company->slug)}}" class=" d-flex gap-2">
                          <img src="{{asset($similarService->company->avatar)}}" alt="{{$similarService->company->name}}" style="width: 20px; height: 20px; border-radius: 50%">
                          <span>
                            {{$similarService->company->name}}
                          </span>
                        </a>
                      </div>
                      <div class="psd-prices">
                        <div class="psd-prices-left">
                          <x-old-prices :prices="$similarService->oldPrices" />
                          <span>
                            {{ number_format($similarService->price, 0, ',', '.') }} TL </span>
                        </div>
                        <div class="psd-prices-right">
                          {{ $similarService->payment_type == 'card' ? 'Kart' : 'Nakit' }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div> @endforeach
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </div> @include('site.home.footer')
  </div>
</div> <!-- İletişim Bilgileri Popup -->
<div id="iletisimBilgileriPopup" class="iletisim-popup" style="display: none;">
  <div class="iletisim-popup-header">
    <h5 class="iletisim-popup-title">İletişim Bilgileri</h5>
    <button type="button" class="iletisim-popup-close" onclick="closeIletisimPopup()" aria-label="Close">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>
  <div class="iletisim-popup-body">
    <p style="margin: 0; font-size: 16px;">
      <strong>{{$service->company->authorized}}</strong> :
      <a href="tel:{{$service->company->mobile_phone}}" style="color: #4068e2; text-decoration: none; font-weight: 600;">
        {{$service->company->mobile_phone}}
      </a>
    </p>
  </div>
</div>

@auth() <div class="modal fade login-modal" id="firmasikayeti" tabindex="-1" aria-labelledby="firmasikayetiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="firmasikayetiLabel">Hizmet Şikayeti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('services.report', $service->slug)}}" method="POST">
          <div class="firma-sikayeti-box">
            <textarea id="w3review" name="message" rows="4" cols="50" maxlength="4800" required placeholder="Şikayetiniz"></textarea> @csrf <div class="login-button">
              <button type="submit"> Gönder </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> @endauth @endsection @section('js') <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
  // Login modal functions - Header'daki login popup'ı çağır
  function openLoginModal() {
    // Header'daki login modal'ı aç
    const headerLoginModal = document.getElementById('exampleModalToggle');
    if (headerLoginModal) {
      var loginModal = new bootstrap.Modal(headerLoginModal);
      loginModal.show();
    }
  }
</script>
<script>
  let direction = window.innerWidth > 991 ? 'vertical' : 'horizontal';
  const thumbSwiper = new Swiper(".mySwiper6", {
    direction: window.innerWidth > 991 ? 'vertical' : 'horizontal',
    slidesPerView: 4,
    spaceBetween: 10,
    freeMode: true,
    watchSlidesProgress: true,
    loop: true, // Ekle
  });
  const mainSwiper = new Swiper(".mySwiper7", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true, // Ekle
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    thumbs: {
      swiper: thumbSwiper,
    },
  });
  // Responsive yön ve güncelleme
  window.addEventListener('resize', function() {
    const newDirection = window.innerWidth > 991 ? 'vertical' : 'horizontal';
    if (thumbSwiper.params.direction !== newDirection) {
      thumbSwiper.changeDirection(newDirection);
      thumbSwiper.update();
    }
  });

  // Alternatif çözüm: Bootstrap tab'ları devre dışı bırak, kendi sistemimizi yaz
  document.addEventListener('DOMContentLoaded', function() {
    let lastClickTime = 0;
    let isProcessing = false;
    const clickDelay = 200; // 200ms - çok daha kısa

    // Bootstrap tab fonksiyonunu devre dışı bırak
    const allTabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
    allTabButtons.forEach(button => {
      button.removeAttribute('data-bs-toggle');
      button.removeAttribute('data-bs-target');
    });

    // Kendi tab fonksiyonumuzu yaz
    function showTab(targetId, clickedButton) {
      // Eğer işlem devam ediyorsa veya çok hızlı tıklama varsa engelle
      const now = Date.now();
      if (isProcessing || (now - lastClickTime < clickDelay)) {
        return;
      }

      // Aynı tab'a tıklanıyorsa işlem yapma
      if (clickedButton.classList.contains('active')) {
        return;
      }

      lastClickTime = now;
      isProcessing = true;

      // Sadece tıklanan butonu kısa süre devre dışı bırak
      clickedButton.classList.add('processing');

      // Hemen tab değişimini yap
      // Tüm tab content'leri gizle
      const allTabPanes = document.querySelectorAll('.tab-pane');
      allTabPanes.forEach(pane => {
        pane.classList.remove('show', 'active');
      });

      // Tüm tab button'larından active sınıfını kaldır
      const currentTabButtons = clickedButton.closest('.nav-tabs').querySelectorAll('.nav-link');
      currentTabButtons.forEach(btn => {
        btn.classList.remove('active');
        btn.setAttribute('aria-selected', 'false');
      });

      // Seçilen tab'ı göster
      const targetPane = document.querySelector(targetId);
      if (targetPane) {
        targetPane.classList.add('show', 'active');
      }

      // Tıklanan button'ı aktif yap
      clickedButton.classList.add('active');
      clickedButton.setAttribute('aria-selected', 'true');

      // Processing'i kaldır
      setTimeout(() => {
        clickedButton.classList.remove('processing');
        isProcessing = false;
      }, 100);
    }

    // Desktop tabs
    document.querySelector('#home-tab')?.addEventListener('click', function(e) {
      e.preventDefault();
      showTab('#home', this);
    });

    document.querySelector('#profile-tab')?.addEventListener('click', function(e) {
      e.preventDefault();
      showTab('#profile', this);
    });

    document.querySelector('#profile1-tab')?.addEventListener('click', function(e) {
      e.preventDefault();
      showTab('#profile1', this);
    });

    // Mobile tabs
    document.querySelector('#home-tab1')?.addEventListener('click', function(e) {
      e.preventDefault();
      showTab('#home-tab1-pane', this);
    });

    document.querySelector('#profile5-tab')?.addEventListener('click', function(e) {
      e.preventDefault();
      showTab('#profile5-tab-pane', this);
    });

    document.querySelector('#contact-tab1')?.addEventListener('click', function(e) {
      e.preventDefault();
      showTab('#contact-tab1-pane', this);
    });
  });

  // İletişim Bilgileri Popup Fonksiyonları
  function showIletisimPopup(buttonElement) {
    const popup = document.getElementById('iletisimBilgileriPopup');
    if (!popup || !buttonElement) return;

    // Butonun pozisyonunu al
    const rect = buttonElement.getBoundingClientRect();
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

    // Popup'ı göster
    popup.style.display = 'block';

    // Popup'ı butonun hemen altına konumlandır
    const popupHeight = popup.offsetHeight;
    const popupWidth = popup.offsetWidth;
    const buttonWidth = rect.width;

    // Yatay pozisyon: butonun ortasına göre popup'ı ortala
    let left = rect.left + scrollLeft + (buttonWidth / 2) - (popupWidth / 2);

    // Ekran sınırlarını kontrol et
    const windowWidth = window.innerWidth;
    if (left < 10) {
      left = 10;
    } else if (left + popupWidth > windowWidth - 10) {
      left = windowWidth - popupWidth - 10;
    }

    // Dikey pozisyon: butonun hemen altına yerleştir
    let top = rect.bottom + scrollTop + 8; // 8px boşluk

    popup.style.left = left + 'px';
    popup.style.top = top + 'px';

    // Dışarı tıklandığında kapat
    setTimeout(() => {
      document.addEventListener('click', closeIletisimPopupOnOutsideClick);
    }, 100);
  }

  function closeIletisimPopup() {
    const popup = document.getElementById('iletisimBilgileriPopup');
    if (popup) {
      popup.style.display = 'none';
    }
    document.removeEventListener('click', closeIletisimPopupOnOutsideClick);
  }

  function closeIletisimPopupOnOutsideClick(event) {
    const popup = document.getElementById('iletisimBilgileriPopup');
    const araButtons = document.querySelectorAll('.ara-button');

    // Popup içine veya Ara butonuna tıklanmışsa kapatma
    if (popup && popup.contains(event.target)) {
      return;
    }

    let clickedAraButton = false;
    araButtons.forEach(btn => {
      if (btn.contains(event.target)) {
        clickedAraButton = true;
      }
    });

    if (!clickedAraButton) {
      closeIletisimPopup();
    }
  }

  // Login popup fonksiyonları (master.blade.php'den kopyalandı)
  function showLoginPopup(message, triggerElement) {
    const popup = document.getElementById('login-popup');
    const messageElement = document.getElementById('login-popup-message');

    if (popup && messageElement && triggerElement) {
      messageElement.textContent = message;

      const rect = triggerElement.getBoundingClientRect();
      const isMobile = window.innerWidth <= 768;

      popup.style.display = 'block';
      popup.style.position = 'fixed';

      if (isMobile) {
        popup.style.left = 'auto';
        popup.style.right = '-20px';
        popup.style.transform = 'none';
        popup.style.top = (rect.top - 30) + 'px';
        popup.style.width = '260px';
      } else {
        popup.style.left = (rect.left + rect.width / 2 - 118) + 'px';
        popup.style.top = (rect.top - 120) + 'px';
        popup.style.width = '236px';
        popup.style.transform = 'none';
      }

      popup.style.zIndex = '1040';
      popup.classList.add('show');

      setTimeout(() => {
        closeLoginPopup();
      }, 5000);
    }
  }

  function closeLoginPopup() {
    const popup = document.getElementById('login-popup');
    if (popup) {
      popup.style.display = 'none';
      popup.classList.remove('show');
    }
  }

  // Fiyat geçmişi popup'ını kapat
  function closeFiyatGecmisiPopup() {
    const popup = document.querySelector('.fiyat-gecmisi-area.active');
    if (popup) {
      popup.classList.remove('active');
    }
  }

  // Fiyat geçmişi popup kapanma fonksiyonu artık component'te inline olarak çağrılıyor

  // CSS ile hover efektlerini tamamen devre dışı bırak ve border'ları sabitle
  const style = document.createElement('style');
  style.textContent = `
    /* Border'ları her zaman sabit tut - kayma olmasın */
    .nav-tabs .nav-link {
      border: 1px solid transparent !important;
      transition: none !important;
      box-sizing: border-box !important;
    }
    
    /* Active durumda bile border kalınlığı değişmesin */
    .nav-tabs .nav-link.active {
      border-color: #dee2e6 #dee2e6 #fff !important;
      border-width: 1px !important;
    }
    
    /* Hover durumunda hiçbir border değişikliği olmasın */
    .nav-tabs .nav-link:hover {
      border: 1px solid transparent !important;
      color: inherit !important;
      background-color: transparent !important;
      transform: none !important;
    }
    
    /* Active tab hover'ında bile border değişmesin */
    .nav-tabs .nav-link.active:hover {
      border-color: #dee2e6 #dee2e6 #fff !important;
      border-width: 1px !important;
    }
    
    /* Focus durumunda outline kaldır */
    .nav-tabs .nav-link:focus {
      outline: none !important;
      box-shadow: none !important;
      border-width: 1px !important;
    }
    
    /* Active durumunda transform kaldır */
    .nav-tabs .nav-link:active {
      transform: none !important;
      border-width: 1px !important;
    }
    
    /* Processing durumunda hafif görsel geri bildirim */
    .nav-tabs .nav-link.processing {
      pointer-events: none !important;
      opacity: 0.9 !important;
      cursor: not-allowed !important;
      border-width: 1px !important;
      transition: opacity 0.1s ease !important;
    }
    
    /* Nav-tabs container'ının border'ını da sabitle */
    .nav-tabs {
      border-bottom: 1px solid #dee2e6 !important;
    }
  `;
  document.head.appendChild(style);
</script> @endsection