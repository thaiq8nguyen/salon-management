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
        'description',
        'debit',
        'credit',
    ];
    protected $hidden = ['laravel_through_key', 'credit', 'id'];
    protected $casts = ['creditAmount' => 'double', 'date' => 'date:m/d/y'];
    protected $maps = ['credit' => 'creditAmount', 'id' => 'transactionId'];
    protected $appends = ['creditAmount', 'transactionId'];


    public function transactionable()
    {
        return $this->morphTo();
    }

    public function getCreditAmountAttribute()
    {
        return $this->attributes['credit'];
    }

    public function getTransactionIdAttribute()
    {
        return $this->attributes['id'];
    }




}
