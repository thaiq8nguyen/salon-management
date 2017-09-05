<?php

namespace Salon\Repositories\PaymentReportRepository;

use Illuminate\Support\ServiceProvider;

class PaymentReportServiceProvider extends ServiceProvider
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
            'Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface',
            'Salon\Repositories\PaymentReportRepository\PaymentReportRepository');
    }
}