@extends('layout')

@section('head')
<title>Forecasts - Popular Cities</title>
@endsection

@section('page-header')
<h1>Forecasts - Popular Cities</h1>
@endsection

@section('middle')
<div id="middle-popular">
    

    @foreach ($forecasts as $forecast)
        <div class="popular-card" id="popular-city_name">
            <img src="{{asset('images/city_cards/medium_size/'.$forecast->city.'.jpg')}}" alt="">
            <div id="popular-card-details">
    
                <div class="popular-card-country">
                    <img  id="popular-card-icon" src="{{asset('images/icons/countries/'.$forecast->country.'.svg')}}" alt="">
                    <span>{{$forecast->city}}, {{$forecast->country}}</span>
                </div>
                <div class="popular-card-description">
                    @includeIf('icons.description.' . $forecast->icon)                
                    <span>{{ucwords($forecast->description)}}</span>
                </div>
                <div class="popular-card-temprature">
                    @switch($forecast->temprature_celsius)
                    @case($forecast->temprature_celsius < -10)
                        @includeIf('icons.temprature.below_minus_10')
                    @break
                    
                    @case($forecast->temprature_celsius >= -10 && $forecast->temprature_celsius <= 0)
                        @includeIf('icons.temprature.0_to_minus_10')
                    @break
    
                    @case($forecast->temprature_celsius > 0 && $forecast->temprature_celsius <= 15)
                        @includeIf('icons.temprature.10_to_0')
                    @break
    
                    @case($forecast->temprature_celsius > 15 && $forecast->temprature_celsius <= 35)
                        @includeIf('icons.temprature.35_to_10')
                    @break
    
                    @case($forecast->temprature_celsius > 35)
                        @includeIf('icons.temprature.above_35')
                    @break
    
                @endswitch
                    <span>{{$forecast->temprature_celsius}} °C</span>
                </div>
                <div class="popular-card-humidity">
                @includeIf('icons.humidity.humidity_default')
                    <span>{{$forecast->humidity}}%</span>
                </div>
                <div class="popular-card-wind">
                @includeIf('icons.wind.wind_default')
                    <span>{{$forecast->wind_speed}} m/s </br> {{ucwords($forecast->wind_direction)}}</span>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection

