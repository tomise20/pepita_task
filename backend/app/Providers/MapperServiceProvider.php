<?php

namespace App\Providers;

use App\Contracts\Mapper;
use App\Mappers\ReservationMapper;
use Illuminate\Support\ServiceProvider;

class MapperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Mapper::class, ReservationMapper::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
