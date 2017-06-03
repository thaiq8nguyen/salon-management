<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalonSale extends Model
{
    protected $fillable = ['date','gross_sales','tips','fees','cash_collected','cards_collected'];
    public function salonSaleDetails(){
        return $this->hasMany(SalonSaleDetails::class);
    }
}
