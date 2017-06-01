<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalonSaleDetails extends Model
{
    protected $fillable = ['item','gross_sales','items_sold'];
    public function sale(){
        return $this->belongsTo(SalonSale::class);
    }
}
