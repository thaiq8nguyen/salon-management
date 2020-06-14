<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Class PayPeriod
 * @mixin Eloquent
 */
class PayPeriod extends Model
{
    protected $appends = ['beginDate', 'endDate', 'payDate', 'name'];
    protected $fillable = ['begin_date', 'end_date', 'pay_date'];
    protected $maps = ['beginDate' => 'begin_date', 'endDate' => 'end_date', 'pay_date' => 'pay_date'];
    protected $hidden = ['begin_date', 'end_date', 'pay_date', 'created_at', 'updated_at'];

    public function paymentReports()
    {
        return $this->hasMany(PaymentReport::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'payment_reports')->withPivot('url');
    }

    public function getBeginDateAttribute()
    {
        return $this->attributes['begin_date'];
    }

    public function getEndDateAttribute()
    {
        return $this->attributes['end_date'];
    }

    public function getPayDateAttribute()
    {
        return $this->attributes['pay_date'];
    }

    public function getNameAttribute()
    {
        return $this->attributes['begin_date'] . ' - ' . $this->attributes['end_date'];
    }

}
