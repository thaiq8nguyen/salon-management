<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TechnicianSale extends Model
{
    protected $dates = ['sale_date'];
    //
    public function technician(){

        return $this->belongsTo(Technician::class);
    }

    /*public function getSaleDateAttribute($value){

        $date = Carbon::createFromFormat('Y-m-d',$value);
        return $date->month.'/'.$date->day.'/'.$date->year;

    }*/

}
