<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayPeriod;

class PayPeriodApiController extends Controller
{
    /*public function __construct(){
        $this->middleware('auth:api');
    }*/

    public function current(){
        $period = PayPeriod::select('begin_date','end_date')->latest()->first();
        $payPeriod = ['beginDate' => $period->begin_date_mdy, 'endDate' => $period->end_date_mdy,];
        return response()->json($payPeriod);
    }
}
