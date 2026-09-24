@extends('site.inc.master')

@section('css')
    <style>
        .popular-slider.one-cikan-firmalar-slider img {
            border: 2px solid #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="main">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right">
                <x-slider />
                @include('site.home.category', ['categories' => $categories])
                @include('site.home.popular-services', ['services' => $services])
                @include('site.home.fikir', ['ideas' => $ideas])
                @include('site.home.firmalar', ['companies' => $companies])
                @include('site.home.footer')

            </div>
        </div>
    </div>
@endsection
