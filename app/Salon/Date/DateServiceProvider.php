<?php namespace Salon\Date;

use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider
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
        $this->app->bind('Salon\Date\DateInterface','Salon\Date\DateRepository');
    }
}
