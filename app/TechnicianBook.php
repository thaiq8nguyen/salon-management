<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianBook extends Model
{
    protected $guarded = [];

    public function scopeTotalBalance($query){

        return $query->selectRaw('(sum(sales) - sum(payments)) as balance');
    }

    public function scopePeriodBalance($query){

        return $query->selectRaw('(sum(sales) - sum(payments)) as balance');
    }


    public function scopeTechnician($query, $technicianId){

        return $query->where('technician_id','=',$technicianId);
    }

    public function scopePayPeriod($query, $payPeriodId){

        return $query->where('pay_period_id','=',$payPeriodId);
    }



}
