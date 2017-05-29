<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PayPeriod;

class PayPeriodApiController extends Controller
{
    /*public function __construct(){
        $this->middleware('auth:api');
    }*/

    public function current(){

        $date = Carbon::now()->toDateString();

        $payPeriod = PayPeriod::where([['begin_date','<=',$date],['pay_date','>=', $date]])->first();

        $currentPayPeriod = ['beginDate' => $payPeriod->begin_date_mdy, 'endDate' => $payPeriod->pay_date_mdy,];

        return response()->json($currentPayPeriod);
    }
}
