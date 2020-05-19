<?php

namespace App\Salon\PayPeriods;


use App\PayPeriod;
use Carbon\Carbon;

class PayPeriodRepository implements PayPeriodInterface
{
    public function getCurrentPayPeriod()
    {
        $today = Carbon::now()->toDateString();
        return PayPeriod::where([['begin_date','<=',$today],['end_date', '>=', $today]])->first(['id', 'begin_date', 'end_date']);
    }

    public function getFuturePayPeriods()
    {
        $today = Carbon::now()->toDateString();
        $current = PayPeriod::where([['begin_date','<=',$today],['end_date', '>=', $today]])->first();

        $future = PayPeriod::where('pay_date', '>=', $current->pay_date)->orderBy('pay_date', 'asc')->limit(3)
            ->get(['id', 'begin_date', 'end_date', 'pay_date']);

        return $future;
    }
}
