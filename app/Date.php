<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $fillable = ['full_date','day','month_number','month_name',
        'day_number_of_week','day_number_of_month','number_of_days_in_month','number_of_days_in_year'];

    public function technicians(){

        return $this->belongsToMany(Technician::class,'technician_schedules')
            ->withPivot('is_working')
            ->withTimestamps();

    }
}
