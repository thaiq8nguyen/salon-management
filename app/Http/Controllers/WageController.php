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
    public function __construct(){
        $this->middleware(['auth', 'checkPayPeriod']);
    }
    /**Route: /wages/pay
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payday(){

        $payPeriod = session()->get('payPeriod');

        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];

        $payPeriodID = $payPeriod->id;

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

                function($query) use($payPeriodID){
                    $query->where('pay_period_id', '=', $payPeriodID);

            }])->orderBy('last_name')->get(['id','first_name','last_name']);

        return view('wages.payday',['pageTitle' => 'Payday','payPeriodID' => $payPeriodID,'payPeriod'=> $payPeriod->pay_period_mdy, 'payDate'=> $payPeriod->pay_date_mdy,
            'technicians'=> $technicians]);
    }


}
