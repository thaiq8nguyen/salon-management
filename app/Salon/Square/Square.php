<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 6/2/17
 * Time: 5:59 PM
 */
namespace Salon\Square;
use Illuminate\Support\Facades\Facade;

Class Square extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'square';
    }
}