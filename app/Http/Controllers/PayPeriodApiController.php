<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PayPeriod;

class PayPeriodApiController extends Controller
{


    public function listing(){

        $date = Carbon::now()->toDateString();

        $payPeriod = PayPeriod::where([['begin_date','<=',$date],['end_date','>=', $date]])->first();

        if(!$payPeriod){
            return response()->json('New period is not in the database',422)->header('Content-type','application/json');
        }

        $periods = PayPeriod::where('pay_date','<=', $payPeriod->pay_date)->offset(2)->limit(5)->orderBy('pay_date','asc')
            ->get(['id','begin_date','end_date','pay_date']);



        $list = [];

        foreach($periods as $period){
            $list[] = ['id' => $period->id, 'periods' => $period->begin_date_mdy . ' - ' . $period->end_date_mdy, 'payDate' => $period->pay_date_mdy];
        }
        return response()->json($list)->header('Content-type', 'application/json');
    }
}
