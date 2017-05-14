<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    public function technician(){

        $this->belongsTo(Technician::class);
    }
}
