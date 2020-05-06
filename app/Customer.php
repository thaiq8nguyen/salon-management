<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class Customer extends Model
{
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
