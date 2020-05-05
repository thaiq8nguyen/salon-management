<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TransactionDetail;

class TransactionItem extends Model
{
    public function transactions()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
}
