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

        $forecast = $this->forecastRepository->getDataFromAPI();

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
        return "hello world! this is the index method.";
    }
}
