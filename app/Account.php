<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use App\Transaction;

/**
 * Account
 * @mixin Eloquent
 */
class Account extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function lastTransaction()
    {
        return $this->hasOne(Transaction::class)->latest('id');
    }
}
