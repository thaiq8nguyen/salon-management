<?php

namespace Salon\Repositories\TechnicianRepository;

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
            'Salon\Repositories\TechnicianRepository\TechnicianRepositoryInterface',
            'Salon\Repositories\TechnicianRepository\TechnicianRepository');
    }
}
