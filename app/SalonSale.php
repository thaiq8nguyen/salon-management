<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalonSale extends Model
{
    protected $fillable = ['date','gross_sales','giftcard_sold','giftcard_redeemed','tips'];
    public function salonSaleDetails(){
        return $this->hasMany(SalonSaleDetails::class);
    }
}
