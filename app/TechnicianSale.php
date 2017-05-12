<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianSale extends Model
{
    protected $dates = ['sale_date'];
    //
    public function technician(){

        return $this->belongsTo(Technician::class);
    }
}
