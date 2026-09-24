@extends('site.inc.master')

@section('content')
    <div class="main sidebar pt-5 mt-4">
        <div class="px-4" id="index-right-area">
            <h1>{{$page->title}}</h1>

            {!! clean($page->content) !!}
        </div>
    </div>
@endsection
