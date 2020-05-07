<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;
use Eloquent;

/**
 * Class Transaction
 * @mixin Eloquent
 */
class Transaction extends Model
{
    protected $fillable = [
        'account_id',
        'transaction_item_id',
        'date',
        'note',
        'debit',
        'credit'
    ];

    protected $hidden = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }


}
