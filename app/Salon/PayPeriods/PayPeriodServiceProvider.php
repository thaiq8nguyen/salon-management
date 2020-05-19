<?php

namespace App\Salon\PayPeriods;

use Illuminate\Support\ServiceProvider;

class PayPeriodServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            'App\Salon\PayPeriods\PayPeriodInterface',
            'App\Salon\PayPeriods\PayPeriodRepository');
    }
}
