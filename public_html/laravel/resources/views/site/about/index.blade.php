@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="hakkimizda index-right just-about-page">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hakkimizda-box">
                                <h1>
                                    {{$about->title}}
                                </h1>

                                {!! clean($about->content, 'titles') !!}

                                <div class="vision-mission-box">
                                    @if($about->box1_content)
                                        <div class="vmb-box ms-0">
                                            <h3>
                                                Vizyon
                                            </h3>
                                            <p>{{$about->box1_content}}</p>
                                        </div>
                                    @endif

                                    @if($about->box1_content)
                                        <div class="vmb-box me-0">
                                            <h3>
                                                Misyon
                                            </h3>
                                            <p>{{$about->box2_content}}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
