<?php

namespace Salon\Repositories\PayDayRepository;

use Illuminate\Support\ServiceProvider;

class PaydayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Salon\Repositories\PayDayRepository\PayDayRepositoryInterface',
            'Salon\Repositories\PayDayRepository\PayDayRepository');
    }
}