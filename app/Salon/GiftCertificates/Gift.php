<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 8/16/17
 * Time: 9:32 PM
 */

namespace Salon\GiftCertificates;

use Illuminate\Support\Facades\Facade;

Class Gift extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'gift';
    }
}