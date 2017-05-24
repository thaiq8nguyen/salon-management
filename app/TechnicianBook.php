<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianBook extends Model
{
    protected $guarded = [];
    public function getBalanceAmountAttribute(){
        return '$ ' . $this->balance;
    }
}
