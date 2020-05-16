<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;


/**
 * Account
 * @mixin Eloquent
 */
class TechnicianAccount extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function balance()
    {
        return $this->transactions()->selectRaw('SUM(credit) - SUM(debit) as balance')->groupBy('account_id')
            ->limit(1);
    }

    public function lastTransaction()
    {
        return $this->hasOne(Transaction::class)->latest('id');
    }


}
