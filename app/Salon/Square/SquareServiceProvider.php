<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 6/2/17
 * Time: 4:23 PM
 */
namespace Salon\Square;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class SquareServiceProvider extends ServiceProvider
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
        $this->app->bind('square', function(){
            $client = new Client(['base_uri'=>'https://connect.squareup.com/v1/']);

            return new SquareAPI($client);
        });

    }
}