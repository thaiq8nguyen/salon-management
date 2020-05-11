<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
