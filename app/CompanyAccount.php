<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyAccount extends Model
{
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

}
