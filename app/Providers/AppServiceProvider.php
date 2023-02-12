<?php

namespace App\Providers;

use Shared\ApiExceptionListener;
use Illuminate\Support\ServiceProvider;
use Shared\ApiExceptionsHttpStatusCodeMapping;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiExceptionsHttpStatusCodeMapping::class, function ($app) {
            return new ApiExceptionsHttpStatusCodeMapping();
        });

        $this->app->singleton(ApiExceptionListener::class, function ($app) {
            return new ApiExceptionListener($app->make(ApiExceptionsHttpStatusCodeMapping::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
