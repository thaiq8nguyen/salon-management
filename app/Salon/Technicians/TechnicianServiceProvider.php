<?php

namespace App\Salon\Technicians;

use Illuminate\Support\ServiceProvider;

class TechnicianServiceProvider extends ServiceProvider
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
            'App\Salon\Technicians\TechnicianInterface',
            'App\Salon\Technicians\TechnicianRepository');
    }
}
