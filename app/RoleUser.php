<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
