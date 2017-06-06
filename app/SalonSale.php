<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalonSale extends Model
{
    protected $fillable = ['date','gross_sales','tips','fees','cash_collected','cards_collected'];

    public function salonSaleDetails(){
        return $this->hasMany(SalonSaleDetails::class);
    }

    public function getGrossSalesAmountAttribute(){

        return '$ '. $this->gross_sales;

    }

    public function getTipsAmountAttribute(){

        return '$ '. $this->tips;

    }

    public function getFeesAmountAttribute(){

        return '$ '. $this->fees;

    }

    public function getCashAmountAttribute(){

        return '$ '. $this->cash_collected;

    }

    public function  etCardsAmountAttribute(){

        return '$ '. $this->cards_collected;

    }
}
