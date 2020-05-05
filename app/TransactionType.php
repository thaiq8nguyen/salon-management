<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transactions;

class TransactionType extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
