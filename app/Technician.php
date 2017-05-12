<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/*
 * @property $first_name
 */
class Technician extends Model
{
    //
    public function sales(){
        return $this->hasMany(TechnicianSale::class)->select(['id','sale_date','sales','additional_sales'])->orderBy('sale_date','ASC');
    }

    public function getRouteKeyName(){
        return 'first_name';
    }


}
