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

    public function dump()
    {
        ddd('hello world! repository works!');
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

    public function getDataFromAPI()
    {
        $api_key = config('services.owm.token');
        $city_name = htmlspecialchars(request('city_name')); //can use spaces
        $results = Http::get('api.openweathermap.org/data/2.5/weather?q='.$city_name.','.'&appid='.$api_key)->object();

        if($results->cod == 200)
        {   
            $forecast = new Forecast;

            $forecast = $results;

            $forecast->string_direction = $this->getDirection($results->wind->deg);
            $forecast->icon_name = $results->weather['0']->icon;
            $forecast->temprature_kelvin = $results->main->temp;
            $forecast->temprature_celsius = $forecast->temprature_kelvin -272.15;
            $forecast->feels_like_kelvin = $results->main->feels_like;
            $forecast->feels_like_celsius = $forecast->feels_like_kelvin -272.15; 

            return $forecast;
            
        }
        //if the results are not okay, it returns the "search" page with an error message appended
        else
        {
            return redirect('/search')->with('search_error', "City $city_name not found or data not available.");
        }
    }
}