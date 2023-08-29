<?php

namespace App\Providers;

use App\Contracts\ClientTimeService;
use App\Contracts\ReservationService;
use App\Services\ClientTimeServiceImpl;
use App\Services\ReservationServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ReservationService::class, ReservationServiceImpl::class);
        $this->app->singleton(ClientTimeService::class, ClientTimeServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
