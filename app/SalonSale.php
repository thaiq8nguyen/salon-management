<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalonSale extends Model
{
    public function saleDetails(){
        return $this->hasMany(SalonSaleDetails::class);
    }
}
