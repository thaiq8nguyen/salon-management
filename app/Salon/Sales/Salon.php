<?php
namespace Salon\Sales;
use Illuminate\Support\Facades\Facade;

class Salon extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'salon';
    }
}
