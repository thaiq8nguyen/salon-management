<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WagePayment extends Model
{
    protected $fillable = ['technician_id','pay_period_id','amount','reference','method','pay_date','expense_account'];

    public function technician(){

        return $this->belongsTo(Technician::class);
    }

    public function payPeriod(){

        return $this->belongsTo(PayPeriod::class);
    }

}
