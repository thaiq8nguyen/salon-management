<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianDetail extends Model
{
    protected $appends = ['commissionRate', 'tipRate', 'technicianId'];
    protected $casts = ['commission_rate' => 'double', 'tip_rate' => 'double'];
    protected $hidden = ['commission_rate', 'tipRate', 'technician_id', 'created_at', 'updated_at'];
    protected $maps = ['technicianId' => 'technician_id'];



    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function getTechnicianIdAttribute()
    {
        return $this->attributes['technician_id'];
    }

    public function getCommissionRateAttribute()
    {
        return $this->attributes['commission_rate'];
    }

    public function getTipRateAttribute()
    {
        return $this->attributes['tip_rate'];
    }


}
