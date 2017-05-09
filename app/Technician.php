<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/*
 * @property $first_name
 */
class Technician extends Model
{
    //

    public function getRouteKeyName()
    {
        return 'first_name';
    }


}
