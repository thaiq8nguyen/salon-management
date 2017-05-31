<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalonSaleDetails extends Model
{
    public function sale(){
        return $this->belongsTo(SalonSale::class);
    }
}
