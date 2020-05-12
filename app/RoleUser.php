<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;


class RoleUser extends Pivot
{

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

}
