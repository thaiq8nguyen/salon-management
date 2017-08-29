<?php

namespace Salon\LogEntries;

use Illuminate\Support\ServiceProvider;

use Monolog\Logger;
use Monolog\Handler\LogEntriesHandler;

class LogEntriesServiceProvider extends ServiceProvider
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
        $this->app->bind('logentries', function(){
            $logger = new Logger('Salon');
            $logger->pushHandler(new LogEntriesHandler(config('services.logentries.token')));

            return new LogEntries($logger);
        });

    }
}
