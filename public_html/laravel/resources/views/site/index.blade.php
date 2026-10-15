@extends('site.inc.master')

@section('css')
    <style>
        .popular-slider.one-cikan-firmalar-slider img {
            border: 2px solid #fff !important;
        }

        @media (max-width: 991px) {
            body > .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            body > .container-fluid > .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .home-index-right {
                margin-top: 48px !important;
                padding: 0 !important;
            }

            .home-index-right .main-slider,
            .home-index-right .main-slider img,
            .home-index-right .main-slider .swiper,
            .home-index-right .main-slider .swiper-slide,
            .home-index-right .main-slider:after {
                border-radius: 0 !important;
                width: 100% !important;
            }

            .home-index-right .home-content {
                padding-top: 0 !important;
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 16px;
                overflow-x: clip;
            }
        }
    </style>
@endsection

@section('content')
    <div class="main">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right home-index-right">
                <x-slider />
                <div class="home-content">
                    @include('site.home.category', ['categories' => $categories])
                    @include('site.home.popular-services', ['services' => $services])
                    @include('site.home.fikir', ['ideas' => $ideas])
                    @include('site.home.firmalar', ['companies' => $companies])
                    
                    {{-- Anasayfa Öne Çıkan Firmalar Altı Reklam Alanı --}}
                    <div class="my-4 text-center">
                        <x-ad-slot format="auto" class="home-firms-bottom-ad" />
                    </div>

                    @include('site.home.footer')
                </div>
            </div>
        </div>
    </div>
@endsection

