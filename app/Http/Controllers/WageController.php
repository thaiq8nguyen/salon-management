<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TechnicianSale;
use App\Technician;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\PayPeriod;
class WageController extends Controller
{
    /**Route: /wages/pay
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payday(){
        $periodID = session()->get('periodID');
        $period = PayPeriod::find($periodID);

        $payPeriod = [$period->begin_date, $period->end_date];


        $technicians = Technician::whereHas('sales',function($query) use ($payPeriod){
            $query->whereBetween('sale_date',$payPeriod);
            })->with(['dailySales' =>
                function($query) use ($payPeriod) {
                    $query->whereBetween('sale_date', $payPeriod);
                },
            'totalSalesAndTips' =>
                function($query) use($payPeriod){
                    $query->whereBetween('sale_date', $payPeriod);
                }
            ])->with(['countPayments' =>

                function($query) use($periodID){
                    $query->where('pay_period_id', '=', $periodID);
            }])

            ->get(['id','first_name','last_name']);


        return view('wages.payday',['payPeriod'=> $period->pay_period_mdy, 'payDate'=> $period->pay_date_mdy,'technicians'=> $technicians]);
    }


}
