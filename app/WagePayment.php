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

    public function scopeToTechnician($query, $technicianId){

        return $query->where('technician_id','=',$technicianId);

    }

    public function scopeBetweenDates($query, $dates){
        return $query->whereBetween('pay_date',$dates);
    }

}
