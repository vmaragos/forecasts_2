<?php

namespace App\Repositories;

use App\Interfaces\ForecastRepositoryInterface;
use App\Models\Forecast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForecastRepository implements ForecastRepositoryInterface
{

    protected $forecast;

    public function __construct(Forecast $forecast)
    {
        $this->forecast = $forecast;
    }

    public function validateCity()
    {
        request()->validate([

            'city_name' => ['required', 'min:2', 'max:20']
        ]);
    }

    public function getDirection($degrees)
    {
        $direction = "undefined";
        switch ($degrees){

            case ($degrees >= 0 && $degrees <= 22.5):
                $direction = "north";
                break;

            case ($degrees >= 22.6 && $degrees <= 67.4 ):
                $direction = "north east";
                break;

            case ($degrees >= 67.5 && $degrees <= 112.5 ):
                $direction = "east";
                break;

            case ($degrees >= 112.6 && $degrees <= 157.4 ):
                $direction = "south east";
                break;

            case ($degrees >= 157.5 && $degrees <= 202.5 ):
                $direction = "south";
                break;

            case ($degrees >= 202.6 && $degrees <= 247.4 ):
                $direction = "south west";
                break;

            case ($degrees >= 247.5 && $degrees <= 292.5 ):
                $direction = "west";
                break;

            case ($degrees >= 292.6 && $degrees <= 337.4 ):
                $direction = "north west";
                break;

            case ($degrees >= 337.5 && $degrees <= 360):
                $direction = "north";
                break;
        }
        return $direction;
    }

    public function getCityResults()
    {
        $api_key = config('services.owm.token');
        $city_name = htmlspecialchars(request('city_name')); //can use spaces
        $results = Http::get('api.openweathermap.org/data/2.5/weather?q='.$city_name.','.'&appid='.$api_key)->object();

        try{
            $forecast = new Forecast;

            $forecast = $results; // include the original api response into the new object

            $forecast->string_direction = $this->getDirection($results->wind->deg);
            $forecast->icon_name = $results->weather['0']->icon;
            $forecast->temprature_kelvin = $results->main->temp;
            $forecast->temprature_celsius = $forecast->temprature_kelvin -272.15;
            $forecast->feels_like_kelvin = $results->main->feels_like;
            $forecast->feels_like_celsius = $forecast->feels_like_kelvin -272.15; 
            
            return $forecast;
        }
        catch(\Exception $exception){
            throw \Illuminate\Validation\ValidationException::withMessages([
                'api_response' => 'Failed to retrieve data for that City. Please type a different one.' 
            ]);
        }
    }

    public function getCitiesResults($city0_id, $city1_id, $city2_id, $city3_id)
    {
        $api_key = config('services.owm.token');
        $results = Http::get('http://api.openweathermap.org/data/2.5/group?id='.$city0_id.','.$city1_id.','.$city2_id.','.$city3_id.'&units=metric '.'&appid='.$api_key)->object();

        $city_forecasts = collect($results->list); // convert the api response from array of objects to a collection

        $forecasts = collect(new Forecast); // create a new collection to add the new objects that will derive from those of the api response
        foreach ($city_forecasts as $city_forecast)
        {
            $forecast = new Forecast;
            // $forecast = $city_forecast;
            $forecast->city = $city_forecast->name;
            $forecast->country = $city_forecast->sys->country;
            $forecast->wind_direction = $this->getDirection($city_forecast->wind->deg);
            $forecast->wind_speed = $city_forecast->wind->speed;
            $forecast->temprature_celsius = $city_forecast->main->temp -272.15;
            $forecast->feels_like_celsius = $city_forecast->main->feels_like -272.15;
            $forecast->humidity = $city_forecast->main->humidity;
            $forecast->description = $city_forecast->weather['0']->description;
            $forecast->icon = $city_forecast->weather['0']->icon;
            
            $forecasts->add($forecast); // add each new forecast object to the collection
        };
        
        return $forecasts;
    }
}