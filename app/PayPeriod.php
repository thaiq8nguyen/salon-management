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
    protected $fillable = ['begin_date', 'end_date', 'pay_date'];
    protected $hidden = ['created_at', 'updated_at'];

    public function paymentReports()
    {
        return $this->hasMany(PaymentReport::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'payment_reports')->withPivot('url');
    }

}
