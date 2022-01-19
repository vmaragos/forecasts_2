<?php

namespace App\Http\Controllers;

use App\Interfaces\ForecastRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForecastsController extends Controller
{

    private $forecastRepository;

    public function __construct(ForecastRepositoryInterface $forecastRepository) 
    {
        $this->forecastRepository = $forecastRepository;
    }

    public function show()
    {
        $this->forecastRepository->validateCity();

        $forecast = $this->forecastRepository->getCityResults();

        return view('results', 
        [
            'results' => $forecast,
            'string_direction' => $forecast->string_direction,
            'icon_name' => $forecast->icon_name,
            'temprature_celsius' => $forecast->temprature_celsius,
            'feels_like_celsius' => $forecast->feels_like_celsius,
        ]);
    }

    public function index()
    {
        $forecasts = $this->forecastRepository->getCitiesResults(2643743, 2950159, 2968815, 3169070); // London, Berlin, Paris, Rome
        
        return view('popular', 
        [
            'forecasts' => $forecasts,
        ]);
    }
}
