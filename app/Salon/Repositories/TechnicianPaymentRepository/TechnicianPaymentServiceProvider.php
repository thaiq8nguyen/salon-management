<?php

namespace Salon\Repositories\TechnicianPaymentRepository;

use Illuminate\Support\ServiceProvider;

class TechnicianPaymentServiceProvider extends ServiceProvider
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
            'Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface',
            'Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepository');
    }
}
