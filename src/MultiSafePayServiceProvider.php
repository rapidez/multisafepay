<?php

namespace Rapidez\MultiSafePay;

use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Eventy;

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

        Eventy::addFilter('checkout.queries.orderV2.data', function($attributes = []) {
            $attributes[] = 'multisafepay_payment_url';
            return $attributes;
        });
    }
}
