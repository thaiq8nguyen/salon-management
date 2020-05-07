<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Class Role
 * @mixin Eloquent
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
