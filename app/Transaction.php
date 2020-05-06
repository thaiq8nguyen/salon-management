<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;

class Transaction extends Model
{
    protected $fillable = [
        
    ];

    protected $hidden = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }
}
