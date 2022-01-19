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
    <!-- <form method="GET" action="{{url('api.openweathermap.org/data/2.5/weather?q=Athens&appid=edf5aedc4d7ff735d0d1a6d2c9397af2')}}"> -->
    <form method="GET" action="{{url('/search/results')}}">
        <img src="{{asset('images/icons/iconfinder_Search_858732.svg')}}" alt="">
        <input type="text" name="city_name" placeholder="Type a city name ..." onfocus="middleFocus()" onfocusout="middleFocusOut()">
        
        @if ($message = Session::get('search_error'))
        <div class="alert_message" id="search_error">
            <span>{{$message}}</span>
        </div>
        @endif
        <script>    
            $(window).on("load",function(){
                
                $("#search_error").delay(3000).css({top: '-25vh'}).fadeOut("slow");
                
            });
        </script>

        <button type="submit" >Search</button>
        <?php
            // $url = 'http://api.openweathermap.org/data/2.5/weather?q=Athens&appid=edf5aedc4d7ff735d0d1a6d2c9397af2';
            // $JSON = file_get_contents($url);

            // echo the JSON (you can echo this to JavaScript to use it there)
            // echo $JSON;

            // You can decode it to process it in PHP
            // $data = json_decode($JSON);
            // var_dump($data);
        ?>
    </form>
    
    <!-- <img src="./images/icons/iconfinder_search_322497.svg" alt=""> -->
    
</div>
@endsection