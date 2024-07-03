<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LoggingService;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the LoggingService in the service container
        $this->app->singleton(LoggingService::class, function ($app) {
            return new LoggingService();
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
