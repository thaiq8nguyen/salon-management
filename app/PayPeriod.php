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
    public function paymentReports()
    {
        return $this->hasMany(PaymentReport::class);
    }
}
