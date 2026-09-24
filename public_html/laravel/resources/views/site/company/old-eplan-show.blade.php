@extends('site.inc.master')


@section('css')
    <style>

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



    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right hizmet-detay-ziyaretci">
                <div class="hizmet-detay-ziyaretci-box hdzb-web-box">
                    <div class="hdzb-left bg-white p-3">
                        <div class="hdzb-title d-flex">
                            <h1 class="text-truncate">
                                {{ $plan->title }}
                            </h1>

                        </div>
                        <div class="hdzb-slider">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                                 class="swiper mySwiper7">
                                <div class="swiper-wrapper">
                                    @foreach($plan->photos as $photo)
                                        <div class="swiper-slide">
                                            <a href="{{asset($photo->path)}}" data-fancybox="gallery"
                                               data-caption="Plan">
                                                <img src="{{asset($photo->path)}}"/>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div thumbsSlider="" class="swiper mySwiper6">
                                <div class="swiper-wrapper">
                                    @foreach($plan->photos as $photo)
                                        <div class="swiper-slide">
                                            <img src="{{asset($photo->path)}}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hdzb-right">
                        <div class="hdzb-right-box">

                            <div class="hdzb-right-links">
                                <ul>
                                    <li>
                                        <a href="">Tüm Planlar</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="hzdb-right-links-bottom">
                                <ul>
                                    <li>
                                        <a href="">
                                            Sözleşmeyi Hazırla
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                          Planı İndir
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                     Metraj
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="hdzb-right-sikayet">
                                <div class="firma-sikayeti-button">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#firmasikayeti">
                                        Plan ile ilgili şikayetim var!
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hdzb-mobil-box">
                    <div class="hdzb-mobil-top">
                        <div class="swiper mySwiper8">
                            <div class="swiper-wrapper">
                                @foreach($plan->photos as $photo)
                                    <div class="swiper-slide">
                                        <div class="hdz-mobil-img">
                                            <a class="hdz-mobil-fancy" href="{{ asset($photo->path) }}"
                                               data-fancybox="gallery" data-caption="Plan">
                                                <img src="{{ asset($photo->path) }}" class="responsive-img"/>
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
                                <a href="">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            </div>
                            <div class="hdzb-mobil-top-right">
                                <a href="javascript:void(0)" class="share-btn">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </a>
                                <a href="">
                                    <i class="fa-regular fa-bookmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="hdzb-mobil-texts">
                        <h3 class="text-truncate">
                            {{ $plan->title }}
                        </h3>
                        <div class="hdzb-mobil-list hdzb-mobil-list-blocks">
                            <div class="hdzb-mobil-list-box">
                                <a href="">
                                    <b>
                                        @if($plan->structureType?->name)
                                                <strong>Tür:</strong>
                                                <span class="fw-normal">{{ $plan->structureType->name }}</span>

                                        @endif
                                    </b>
                                </a>
                            </div>

                            <div class="hdzb-mobil-list-box">
                              <span class="fw-normal d-inline-block ms-2">

                               @if($plan->structureType?->name)
                                      <strong>Oda:</strong>
                                    {{ $plan->structureType->name }}
                                  @endif
                                </span>
                            </div>

                            <div class="hdzb-mobil-list-box">
                              <span class="fw-normal d-inline-block ms-2">

                                     @if($plan->roomCount?->label)
                                      <strong>Oda:</strong>
                                      <span class="fw-normal">{{ $plan->roomCount->label }}</span>
                                  @endif
                                </span>
                            </div>


                            <div class="hdzb-mobil-list-box">
                              <span class="fw-normal d-inline-block ms-2">

                                      @if($plan->net_area)
                                      <strong>Alan:</strong>
                                      <span class="fw-normal"> {{ $plan->net_area }} m²</span>
                                  @endif
                                </span>
                            </div>

                        </div>
                        <div class="hizmet-hakkinda-aciklama hdzb-mobil-aciklama">
                            <div>
                                <p>    {{ $plan->description }}
                                    <span class="hdzm-mobil-hizmet more-hizmet2 ms-3">Daha Az</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="hdzb-mobil-trigger-box w-100">
                        <h5 class="text-truncate">
                            {{ $plan->title }}
                        </h5>
                        <div class="d-flex">

                            <p>

                                {{ $plan->description }}
                            </p>
                            <div class="hdzb-mobil-trigger">
                                daha fazla
                            </div>
                        </div>
                        <div class="hdzb-mobil-list">
                            <div>
                                <a href=""
                                   class="hdzb-mobil-list-box">
                                    <b>
                                        @if($plan->structureType?->name)
                                            <strong>Yapı Türü:</strong>
                                            <span class="fw-normal">{{ $plan->structureType->name }}</span>

                                        @endif
                                    </b>
                                </a>
                            </div>
                            <div class="hdzb-mobil-list-box">
                                <span class="fw-normal d-inline-block ms-2">
                                      @if($plan->structureClass?->name)
                    <strong>Yapı Sınıfı:</strong>
                    <span class="fw-normal">{{ $plan->structureClass->name }}</span>
                                    @endif
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="hdzb-mobil-bottom">
                    <div class="hdzb-mobil-flex">
                        <div class="hdzb-mobil-bottom-left">
                            <a href="">
                                Ara
                            </a>
                            <a href="">
                                Mesaj
                            </a>
                        </div>

                    </div>
                </div>
                <div class="firma-tabs-area hizmet-detay-tabs-area">
                    <div class="firma-tabs-box d-none d-lg-block">
                        <ul class="nav nav-tabs firma-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home"
                                        type="button" role="tab" aria-controls="home" aria-selected="true">
                                    <div class="d-flex flex-wrap gap-3">
                                        @if($plan->structureType?->name)
                                            <div>
                                                <strong>Yapı Türü:</strong> {{ $plan->structureType->name }}
                                            </div>
                                        @endif

                                        @if($plan->structureClass?->name)
                                            <div>
                                                <strong>Yapı Sınıfı:</strong> {{ $plan->structureClass->name }}
                                            </div>
                                        @endif

                                        @if($plan->roomCount?->label)
                                            <div>
                                                <strong>Oda:</strong> {{ $plan->roomCount->label }}
                                            </div>
                                        @endif

                                        @if($plan->net_area)
                                            <div>
                                                <strong>Alan:</strong> {{ $plan->net_area }} m²
                                            </div>
                                        @endif
                                    </div>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="container-fluid firma-services-tab">
                                    <div class="row">
                                        <div class="hizmet-hakkinda-aciklama">

                                            <p class="mt-3 h-100 overflow-y-auto text-break">
                                                {{ $plan->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="fikir-detay-one-cikan-hizmet fikir-detay-popular-slider">
  <div class="popular-services">
    <div class="cs-title d-flex cs-title-link">
      <div class="ctl-left">
        <i class="fa-solid fa-business-time"></i>
        <h2> Benzer Planlar </h2>
      </div>
      <div class="ctl-right">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan"> Tüm Planlar <i class="fa-solid fa-angle-right"></i>
        </a>
      </div>
    </div>
    <div class="popular-slider ">
<div class="swiper mySwiper3">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
            <div class="swiper-slide">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/eplan/5" class="text-decoration-none text-dark">
  <div class="card h-100">
    <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/uploads/plans/photos/687b3df32fd2a.png" class="card-img-top" alt="3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme">
    <div class="card-body">
      <h5 class="card-title">3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme 3+1 Müstakil Ev Planı Deneme</h5>
    </div>
    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
      <span class="badge bg-secondary">Betonarme</span>
      <span class="badge bg-secondary">Müstakil</span>
      <span class="badge bg-secondary">3+1</span>
      <span class="badge bg-secondary">156 m² net</span>
      <span class="badge bg-secondary">175 m² brüt</span>
    </div>
  </div>
</a>
      </div>
    </div>
     <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
    </div>
  </div>
</div>

            </div>
        </div>
    </div>

    <div class="modal fade login-modal" id="firmasikayeti" tabindex="-1" aria-labelledby="firmasikayetiLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="firmasikayetiLabel">Plan Şikayeti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="firma-sikayeti-box">
                            <textarea id="w3review" name="message" rows="4" cols="50" maxlength="4800" required
                                      placeholder="Şikayetiniz"></textarea>
                            @csrf
                            <div class="login-button">
                                <button type="submit">
                                    Gönder
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
