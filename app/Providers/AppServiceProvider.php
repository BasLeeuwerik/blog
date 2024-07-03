<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LoggingService;
use App\Services\LoggingServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LoggingServiceInterface::class, LoggingService::class);
    }

    public function boot()
    {
        //
    }
}
