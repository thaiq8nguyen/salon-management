<?php

namespace App\Http\Controllers;

use App\PayPeriod;
use Illuminate\Http\Request;

class PayPeriodController extends Controller
{
    public function current(){
        $period = PayPeriod::select('begin_date','end_date')->latest()->first();
        $payPeriod = ['beginDate' => $period->begin_date_mdy, 'endDate' => $period->end_date_mdy,];
        return response()->json($payPeriod);
    }
}
