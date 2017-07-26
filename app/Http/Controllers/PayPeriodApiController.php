<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PayPeriod;

class PayPeriodApiController extends Controller
{


    public function current(){

        $date = Carbon::now()->toDateString();

        $payPeriod = PayPeriod::where([['begin_date','<=',$date],['pay_date','>=', $date]])->first();

        $currentPayPeriod = ['id' => $payPeriod->id,'beginDate' => $payPeriod->begin_date_mdy,
            'endDate' => $payPeriod->end_date_mdy,'payDate' => $payPeriod->pay_date_mdy];

        return response()->json($currentPayPeriod,200)->header('Content-type', 'application/json');
    }
}
