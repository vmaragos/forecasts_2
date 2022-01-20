@extends('layout')

@section('head')
<title>Forecasts - Search City</title>
<script type="text/javascript" src="{{asset('js/index.js')}}"></script>
@endsection

@section('page-header')
<h1>Forecasts - Search City</h1>
@endsection

@section('middle')
<div id="middle">
    <form method="GET" action="{{url('/search/results')}}">
        <img src="{{asset('images/icons/iconfinder_Search_858732.svg')}}" alt="">
        <input type="text" name="city_name" placeholder="Type a city name..." onfocus="middleFocus()" onfocusout="middleFocusOut()">
        @error('api_response')
        <div class="alert_message" id="search_error">
            <span>{{$message}}</span>
        </div>
        @enderror
        <script>    
            $(window).on("load",function(){
                $("#search_error").delay(6000).css({top: '-25vh'}).fadeOut("slow");
            });
        </script>
        <button type="submit" >Search</button>
    </form>
</div>
@endsection