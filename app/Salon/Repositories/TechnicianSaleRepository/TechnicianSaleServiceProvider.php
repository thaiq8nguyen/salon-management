<?php

namespace Salon\Repositories\TechnicianSaleRepository;

use Illuminate\Support\ServiceProvider;

class TechnicianSaleServiceProvider extends ServiceProvider
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
            'Salon\Repositories\TechnicianSaleRepository\TechnicianSaleRepositoryInterface',
            'Salon\Repositories\TechnicianSaleRepository\TechnicianSaleRepository');

    }
}
