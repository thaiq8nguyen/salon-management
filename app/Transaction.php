<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TransactionType;

class Transaction extends Model
{
    protected $fillable = [
        'role_user_id', 'transaction_type_id', 'amount', 'date',
    ];

    protected $hidden = [];

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }
}
