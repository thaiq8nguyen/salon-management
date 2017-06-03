<?php

namespace Salon\Sales;
use App\SalonSale;
use Illuminate\Support\ServiceProvider;

class SalonSaleServiceProvider extends ServiceProvider
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
        $this->app->bind('salon',function(){

            $salonSale = new SalonSale();
            return new SalonSaleAPI($salonSale);

        });
    }
}
