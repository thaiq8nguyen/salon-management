<?php

namespace Salon\Repositories\TechnicianWageRepository;

use Illuminate\Support\ServiceProvider;

class TechnicianWageServiceProvider extends ServiceProvider
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
            'Salon\Repositories\TechnicianWageRepository\TechnicianWageRepositoryInterface',
            'Salon\Repositories\TechnicianWageRepository\TechnicianWageRepository');
    }
}
