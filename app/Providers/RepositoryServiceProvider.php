<?php

namespace App\Providers;

use App\Interfaces\ForecastRepositoryInterface;
use App\Repositories\ForecastRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ForecastRepositoryInterface::class, ForecastRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
