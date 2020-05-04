<?php
namespace App\Salon\TechnicianSales;

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
            'App\Salon\TechnicianSales\TechnicianSaleInterface',
            'App\Salon\TechnicianSales\TechnicianSaleRepository'
        );
    }
}
