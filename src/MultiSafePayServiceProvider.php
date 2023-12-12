<?php

namespace Rapidez\MultiSafePay;

use Illuminate\Support\ServiceProvider;

class MultiSafePayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'multisafepay');

        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/multisafepay'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/../resources/payment-icons' => public_path('payment-icons'),
            ], 'payment-icons');
        }
    }
}