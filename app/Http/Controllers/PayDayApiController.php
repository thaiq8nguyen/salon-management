<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayPeriod;
use App\Technician;
use App\WagePayment;
use Carbon\Carbon;
use DB;

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

        $paymentsInput = $request->all();
        $technicianId = $request->input('payingTechnicianId');
        $periodId = $request->input('periodId');
        $technician = Technician::find($technicianId);
        $payPeriod = PayPeriod::find($periodId);
        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];


        $payments = [];
        $totalAmount = 0.0;
        $date = Carbon::now()->toDateString();
        foreach($paymentsInput['payments'] as $payment){

            $totalAmount += $payment['amount'];
            $payment['pay_period_id'] = $periodId;
            $payment['pay_date'] = $date;
            $payment['expense_account'] = 'wages';
            $payments[] = new WagePayment($payment);
        }

        $technician->payments()->saveMany($payments);

        $sales = Technician::with(['totalSalesAndTips' =>
            function ($query) use ($payPeriodDates) {
                $query->whereBetween('sale_date',$payPeriodDates);
            }])->where('id', '=', $technicianId)->first(['id']);

        $totalSale = $sales->totalSalesAndTips[0]->total;

        DB::table('technician_books')->insert(
            ['technician_id' => $technicianId, 'pay_period_id' => $periodId, 'date' => $date,
                'description' => 'sales', 'sales' => $totalSale,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()]);

        DB::table('technician_books')->insert(
            ['technician_id' => $technicianId, 'pay_period_id' => $periodId, 'date' => $date,
                'description' => 'wages', 'payments' => $totalAmount,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()]
        );

        return response()->json(['success'=>true, 'message'=> $technician->full_name . ' \'s is paid!'],200)->header('Content-type','application-json');
    }
}


