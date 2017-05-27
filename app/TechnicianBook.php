<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianBook extends Model
{
    protected $guarded = [];

    public function scopeBalance($query){
        return $query->selectRaw('technician_id, (sum(sales) - sum(payments)) as balance');
    }


}
