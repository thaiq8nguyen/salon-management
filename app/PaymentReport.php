<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PaymentReport extends Model
{
    protected $fillable = ['technician_id','pay_period_id','published','url'];

    public function technician(){

        return $this->belongsTo(Technician::class);

    }

    public function payPeriod(){

        return $this->belongsTo(PayPeriod::class);
    }
}
