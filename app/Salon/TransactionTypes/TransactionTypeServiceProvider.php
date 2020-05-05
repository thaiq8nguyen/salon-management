<?php

namespace App\Salon\TransactionTypes;

use Illuminate\Support\ServiceProvider;

class TransactionTypeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Salon\TransactionTypes\TransactionTypeInterface', 'App\Salon\TransactionTypes\TransactionTypeRepository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
