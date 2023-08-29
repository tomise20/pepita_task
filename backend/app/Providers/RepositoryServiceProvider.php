<?php

namespace App\Providers;

use App\Contracts\ClientTimeRepository;
use App\Contracts\ReservationRepository;
use App\Repositories\ClientTimeRepositoryImpl;
use App\Repositories\ReservationRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ReservationRepository::class, ReservationRepositoryImpl::class);
        $this->app->singleton(ClientTimeRepository::class, ClientTimeRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
