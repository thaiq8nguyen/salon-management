<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayPeriod;
use App\Technician;

class PayDayApiController extends Controller
{
    public function payday(Request $request){

        $payPeriodId = $request->input('id');
        $payPeriod = PayPeriod::find($payPeriodId);

        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];

        $technicians = Technician::whereHas('sales',function($query) use ($payPeriodDates){
            $query->whereBetween('sale_date',$payPeriodDates);
        })->with(['dailySales' =>
            function($query) use ($payPeriodDates) {
                $query->whereBetween('sale_date', $payPeriodDates);
            },
            'totalSalesAndTips' =>
                function($query) use($payPeriodDates){
                    $query->whereBetween('sale_date', $payPeriodDates);
                }
        ])->with(['countPayments' =>

            function($query) use($payPeriodId){
                $query->where('pay_period_id', '=', $payPeriodId);

            }])->orderBy('last_name')->get(['id','first_name','last_name']);


        return response()->json($technicians,200)->header('Content-type','application/json');
    }

    public function payTechnician(Request $request){

        return response()->json($request,200)->header('Content-type','application-json');
    }
}


