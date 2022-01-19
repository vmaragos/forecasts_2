<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ForecastRepositoryInterface
{
    public function dump();

    public function validateCity();

    public function getDirection($degrees);

    public function getDataFromAPI();

}

