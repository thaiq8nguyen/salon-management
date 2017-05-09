<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    //

    public function getRouteKeyName()
    {
        return 'first_name';
    }


}
