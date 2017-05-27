<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TechnicianSale extends Model
{


    protected $fillable = ['technician_id','sales','sale_date','additional_sales'];

    /**
     * return a relationship definition between a Technician and a TechnicianSale models
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technician(){

        return $this->belongsTo(Technician::class);
    }

    /**
     * return a formatted string date as 'm/d/Y
     * @return string
     */
    public function getSaleDateMDYAttribute(){
        return Carbon::createFromFormat('Y-m-d',$this->sale_date)->format('m/d/Y');
    }

    public function getSaleDateMDYDAttribute(){
        return Carbon::createFromFormat('Y-m-d',$this->sale_date)->format('m/d/Y D');
    }

    /**
     * Accessor method to return a sales amount decimal in a currency format
     * @return string
     */
    public function getSalesAmountAttribute(){
        return '$ '. ($this->sales);
    }

    /**
     * Accessor method to return an additional_sales amount decimal in a currency format
     * @return string
     */
    public function getAdditionalSalesAmountAttribute(){
        return '$ '. ($this->additional_sales);
    }



}
