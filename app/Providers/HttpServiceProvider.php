<?php

namespace App\Providers;

use App\HttpServices\Services\GuardianApiService;
use App\HttpServices\Services\NewsApiService;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(NewsApiService::class, function ($app) {
            return new NewsApiService();
        });

        $this->app->singleton(GuardianApiService::class, function ($app) {
            return new GuardianApiService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
