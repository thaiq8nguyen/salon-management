<?php

namespace Salon\GiftCertificates;

use App\GiftCertificate;
use Illuminate\Support\ServiceProvider;

class GiftServiceProvider extends ServiceProvider
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
        $this->app->bind('gift',function(){

            $giftCertificate = new GiftCertificate();
            return new GiftAPI($giftCertificate);

        });
    }
}
