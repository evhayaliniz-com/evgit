@extends('site.inc.master') @section('css') <style>
  .plus {
    display: none;
  }

  .hdzb-left {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
</style> @endsection @section('content') <div class="main sidebar">
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
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper7">
              <div class="swiper-wrapper"> @foreach($plan->photos as $photo) <div class="swiper-slide">
                  <a href="{{asset($photo->path)}}" data-fancybox="gallery" data-caption="Plan">
                    <img src="{{asset($photo->path)}}" />
                  </a>
                </div> @endforeach </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
            <div thumbsSlider="" class="swiper mySwiper6">
              <div class="swiper-wrapper"> @foreach($plan->photos as $photo) <div class="swiper-slide">
                  <img src="{{asset($photo->path)}}" />
                </div> @endforeach </div>
            </div>
          </div>
        </div>
        <div class="hdzb-right">
          <div class="hdzb-right-box">
            <div class="hdzb-right-links">
              <ul>
                <li>
                  <a href="{{ route('company.eplan') }}">Tüm Planlar</a>
                </li>
              </ul>
            </div>
            <div class="hzdb-right-links-bottom">
              <ul>
                <li>
                  <a href=""> Sözleşmeyi Hazırla </a>
                </li>
                <li>
                  @if($plan->file_path)
                  <a href="{{ route('company.eplan.download', $plan) }}"> Planı İndir </a>
                  @else
                  <a href="#" class="text-muted" title="Plan dosyası bulunamadı"> Planı İndir </a>
                  @endif
                </li>
                <li>
                  @if($plan->measurement_file_path)
                  <a href="{{ route('company.eplan.download-measurement', $plan) }}"> Metraj İndir </a>
                  @else
                  <a href="#" class="text-muted" title="Metraj dosyası bulunamadı"> Metraj İndir </a>
                  @endif
                </li>
              </ul>
            </div>
            <div class="hdzb-right-sikayet">
              <div class="firma-sikayeti-button">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#firmasikayeti"> Plan ile ilgili şikayetim var! </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="hdzb-mobil-box eplandetay-mobil-box">
        <div class="hdzb-mobil-top">
          <div class="swiper mySwiper8">
            <div class="swiper-wrapper">
              @forelse($plan->photos as $photo)
              <div class="swiper-slide">
                <div class="hdz-mobil-img">
                  <a class="hdz-mobil-fancy" href="{{ asset($photo->path) }}" data-fancybox="gallery" data-caption="{{ $plan->title }}">
                    <img src="{{ asset($photo->path) }}" class="responsive-img" />
                  </a>
                </div>
              </div>
              @empty
              <div class="swiper-slide">
                <div class="hdz-mobil-img">
                  <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                    <div class="text-center text-muted">
                      <i class="bx bx-image" style="font-size: 3rem;"></i>
                      <p class="mt-2 mb-0">Fotoğraf bulunamadı</p>
                    </div>
                  </div>
                </div>
              </div>
              @endforelse
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          <div class="d-flex">
            <div class="hdzb-mobil-top-left">
              <a href="javascript:history.back()">
                <i class="fa-solid fa-arrow-left"></i>
              </a>
              <a href="{{ url('/eplan') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="M6 19h3v-5q0-.425.288-.712T10 13h4q.425 0 .713.288T15 14v5h3v-9l-6-4.5L6 10zm-2 0v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-4q-.425 0-.712-.288T13 20v-5h-2v5q0 .425-.288.713T10 21H6q-.825 0-1.412-.587T4 19m8-6.75" />
                </svg>
              </a>
            </div>
            <div class="hdzb-mobil-top-right">
              <a href="javascript:void(0)" class="share-btn">
                <i class="fa-solid fa-share-nodes"></i>
              </a>
              <a href="https://www.evhayaliniz.com/services/51-dubleks-ev-anahtar-teslim-88/save">
                <i class="fa-regular fa-bookmark"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="hdzb-mobil-texts eplan-mobil-texts">
          <div class="eplan-mobil-texts-title">
            <div class="eplan-mtt-left">
              <h3 class="text-truncate"> {{ $plan->title }} </h3>
            </div>
            <div class="eplan-mtt-right">
              <div class="eplan-mtt-fullscreen">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Google Material Icons by Material Design Authors - https://github.com/material-icons/material-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="M21.29 4.12L16.7 8.71l1.59 1.59c.63.63.18 1.71-.71 1.71H13c-.55 0-1-.45-1-1v-4.6c0-.89 1.08-1.34 1.71-.71l1.59 1.59l4.59-4.59a.996.996 0 0 1 1.41 0c.38.4.38 1.03-.01 1.42M4.12 21.29l4.59-4.59l1.59 1.59c.63.63 1.71.18 1.71-.71V13c0-.55-.45-1-1-1h-4.6c-.89 0-1.34 1.08-.71 1.71l1.59 1.59l-4.59 4.59a.996.996 0 0 0 0 1.41c.4.38 1.03.38 1.42-.01" />
                </svg>
              </div>
              <div class="eplan-mtt-close more-hizmet2">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                  <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z" />
                </svg>
              </div>
            </div>
          </div>
          <ul class="nav eplanmobiltabs" id="eplanmobiltab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="eplantab1" data-bs-toggle="tab" data-bs-target="#eplantab1-pane" type="button" role="tab" aria-controls="eplantab1-pane" aria-selected="true">Açıklama</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="eplantab2" data-bs-toggle="tab" data-bs-target="#eplantab2-pane" type="button" role="tab" aria-controls="eplantab2-pane" aria-selected="false">Özellikler</button>
            </li>
          </ul>
          <div class="tab-content" id="eplanmobiltabContent">
            <div class="tab-pane fade show active" id="eplantab1-pane" role="tabpanel" aria-labelledby="eplantab1" tabindex="0">
              <div class="hizmet-hakkinda-aciklama hdzb-mobil-aciklama">
                <div>
                  <p>{{ $plan->description }} <span class="hdzm-mobil-hizmet more-hizmet2 ms-3">Daha Az</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="eplantab2-pane" role="tabpanel" aria-labelledby="eplantab2" tabindex="0">
              <div class="eplan-ozellikler-web eplanozellikler-mobil">
                <div class="eplan-ozelliklerbox colorless">
                  <b> Yapı Türü: </b>
                  <span> {{ $plan->structureType->name ?? 'Belirtilmemiş' }} </span>
                </div>
                <div class="eplan-ozelliklerbox">
                  <b> Yapı Sınıfı: </b>
                  <span> {{ $plan->structureClass->name ?? 'Belirtilmemiş' }} </span>
                </div>
                <div class="eplan-ozelliklerbox colorless">
                  <b> Oda Sayısı: </b>
                  <span> {{ $plan->roomCount->label ?? 'Belirtilmemiş' }} </span>
                </div>
                <div class="eplan-ozelliklerbox">
                  <b> Net Alan: </b>
                  <span> {{ $plan->net_area ? $plan->net_area . ' m²' : 'Belirtilmemiş' }} </span>
                </div>
                @if($plan->gross_area)
                <div class="eplan-ozelliklerbox colorless">
                  <b> Brüt Alan: </b>
                  <span> {{ $plan->gross_area }} m² </span>
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="hdzb-mobil-list hdzb-mobil-list-blocks more">
            <div class="hdzb-mobil-list-box">
              <!--<a href="https://www.evhayaliniz.com/companies/bilyap-insaat-enerji-34">
                <b> Bilyap İnşaat Enerji </b>
              </a>-->
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Yapı Türü: {{ $plan->structureType->name ?? 'Belirtilmemiş' }} </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Yapı Sınıfı: {{ $plan->structureClass->name ?? 'Belirtilmemiş' }} </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Oda Sayısı: {{ $plan->roomCount->label ?? 'Belirtilmemiş' }} </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Net Alan m²: {{ $plan->net_area ?? 'Belirtilmemiş' }} </span>
            </div>
            @if($plan->gross_area)
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Brüt Alan m²: {{ $plan->gross_area }} </span>
            </div>
            @endif
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> {{ $plan->structureType->name ?? 'Belirtilmemiş' }} / {{ $plan->structureClass->name ?? 'Belirtilmemiş' }} </span>
            </div>
          </div>
        </div>
        <div class="hdzb-mobil-trigger-box w-100 hdzb-mobil-trigger">
          <h5 class="text-truncate"> {{ $plan->title }} </h5>
          <div class="d-flex">
            <p> {{ Str::limit($plan->description, 150, '...') }} </p>
            <div class="hdzb-mobil-trigger-text"> daha fazla </div>
          </div>
          <div class="hdzb-mobil-list">
            <!-- <div>
              <a href="https://www.evhayaliniz.com/companies/bilyap-insaat-enerji-34" class="hdzb-mobil-list-box">
                <b> Bilyap İnşaat Enerji </b>
              </a>
            </div>-->
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Yapı Türü: {{ $plan->structureType->name ?? 'Belirtilmemiş' }} </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Yapı Sınıfı: {{ $plan->structureClass->name ?? 'Belirtilmemiş' }} </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Oda Sayısı: {{ $plan->roomCount->label ?? 'Belirtilmemiş' }} </span>
            </div>
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Net Alan m²: {{ $plan->net_area ?? 'Belirtilmemiş' }} </span>
            </div>
            @if($plan->gross_area)
            <div class="hdzb-mobil-list-box">
              <span class="fw-normal d-inline-block ms-2"> Brüt Alan m²: {{ $plan->gross_area }} </span>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="hdzb-mobil-bottom">
        <div class="hdzb-mobil-flex">
          <div class="hdzb-mobil-bottom-left">
            @if($plan->measurement_file_path)
            <a href="{{ route('company.eplan.download-measurement', $plan) }}"> Metraj İndir </a>
            @else
            <a href="#" class="text-muted" title="Metraj dosyası bulunamadı"> Metraj İndir </a>
            @endif
            @if($plan->file_path)
            <a href="{{ route('company.eplan.download', $plan) }}"> Plan İndir </a>
            @else
            <a href="#" class="text-muted" title="Plan dosyası bulunamadı"> Plan İndir </a>
            @endif
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
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Özellikler</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="container-fluid firma-services-tab">
                <div class="row">
                  <div class="hizmet-hakkinda-aciklama">
                    <div class="hdzb-mobil-list hizmet-hakkida-aciklama-2">
                      <div class="hdzb-mobil-list-box">
                        <span>Yapı Türü : </span>
                        <span class="fw-normal d-inline-block ms-2"> {{ $plan->structureType->name ?? 'Belirtilmemiş' }} </span>
                      </div>
                      <div class="hdzb-mobil-list-box">
                        <span>Yapı Sınıfı : </span>
                        <span class="fw-normal d-inline-block ms-2"> {{ $plan->structureClass->name ?? 'Belirtilmemiş' }} </span>
                      </div>
                      <div class="hdzb-mobil-list-box">
                        <span>Oda Sayısı : </span>
                        <span class="fw-normal d-inline-block ms-2"> {{ $plan->roomCount->label ?? 'Belirtilmemiş' }} </span>
                      </div>
                      <div class="hdzb-mobil-list-box">
                        <span>Net Alan m² : </span>
                        <span class="fw-normal d-inline-block ms-2"> {{ $plan->net_area ?? 'Belirtilmemiş' }} </span>
                      </div>
                      @if($plan->gross_area)
                      <div class="hdzb-mobil-list-box">
                        <span>Brüt Alan m² : </span>
                        <span class="fw-normal d-inline-block ms-2"> {{ $plan->gross_area }} </span>
                      </div>
                      @endif
                    </div>
                    <p class="mt-3 h-100 overflow-y-auto text-break"> {{ $plan->description }} </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="tab-bg">
                <div class="eplan-ozellikler-web">
                  <div class="eplan-ozelliklerbox colorless">
                    <b> Yapı Türü: </b>
                    <span> {{ $plan->structureType->name ?? 'Belirtilmemiş' }} </span>
                  </div>
                  <div class="eplan-ozelliklerbox">
                    <b> Yapı Sınıfı: </b>
                    <span> {{ $plan->structureClass->name ?? 'Belirtilmemiş' }} </span>
                  </div>
                  <div class="eplan-ozelliklerbox colorless">
                    <b> Oda Sayısı: </b>
                    <span> {{ $plan->roomCount->label ?? 'Belirtilmemiş' }} </span>
                  </div>
                  <div class="eplan-ozelliklerbox">
                    <b> Net Alan: </b>
                    <span> {{ $plan->net_area ? $plan->net_area . ' m²' : 'Belirtilmemiş' }} </span>
                  </div>
                  @if($plan->gross_area)
                  <div class="eplan-ozelliklerbox colorless">
                    <b> Brüt Alan: </b>
                    <span> {{ $plan->gross_area }} m² </span>
                  </div>
                  @endif
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
              <a href="{{ route('company.eplan') }}"> Tüm Planlar <i class="fa-solid fa-angle-right"></i>
              </a>
            </div>
          </div>
          <div class="popular-slider ">
            <div class="swiper mySwiper3">
              <div class="swiper-wrapper">
                @forelse($similarPlans as $similarPlan)
                <div class="swiper-slide">
                  <a href="{{ route('company.eplan.show', $similarPlan->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100">
                      @if($similarPlan->photos->first())
                      <img src="{{ asset($similarPlan->photos->first()->path) }}" class="card-img-top" alt="{{ $similarPlan->title }}" style="height: 200px; object-fit: cover;">
                      @else
                      <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bx bx-image text-muted" style="font-size: 3rem;"></i>
                      </div>
                      @endif
                      <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($similarPlan->title, 60) }}</h5>
                      </div>
                      <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
                        @if($similarPlan->structureType)
                        <span class="badge bg-secondary">{{ $similarPlan->structureType->name }}</span>
                        @endif
                        @if($similarPlan->structureClass)
                        <span class="badge bg-secondary">{{ $similarPlan->structureClass->name }}</span>
                        @endif
                        @if($similarPlan->roomCount)
                        <span class="badge bg-secondary">{{ $similarPlan->roomCount->label }}</span>
                        @endif
                        @if($similarPlan->net_area)
                        <span class="badge bg-secondary">{{ $similarPlan->net_area }} m² net</span>
                        @endif
                        @if($similarPlan->gross_area)
                        <span class="badge bg-secondary">{{ $similarPlan->gross_area }} m² brüt</span>
                        @endif
                      </div>
                    </div>
                  </a>
                </div>
                @empty
                <div class="swiper-slide">
                  <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-center">
                      <div class="text-center text-muted">
                        <i class="bx bx-info-circle mb-2" style="font-size: 2rem;"></i>
                        <p class="mb-0">Benzer plan bulunamadı</p>
                      </div>
                    </div>
                  </div>
                </div>
                @endforelse

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
<div class="modal fade login-modal" id="firmasikayeti" tabindex="-1" aria-labelledby="firmasikayetiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="firmasikayetiLabel">Plan Şikayeti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="firma-sikayeti-box">
            <textarea id="w3review" name="message" rows="4" cols="50" maxlength="4800" required placeholder="Şikayetiniz"></textarea> @csrf <div class="login-button">
              <button type="submit"> Gönder </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> @endsection