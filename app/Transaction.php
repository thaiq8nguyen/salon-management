<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TechnicianAccount;
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
        'credit',
    ];
    protected $hidden = ['laravel_through_key'];



    public function transactionable()
    {
        return $this->morphTo();
    }




}
