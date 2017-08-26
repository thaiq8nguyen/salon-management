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

        $technicians = Technician::with([
            'dailySales' =>
            function($query) use ($payPeriodDates) {
                $query->whereBetween('sale_date', $payPeriodDates);
            },

            'totalSalesAndTips' =>
            function($query) use($payPeriodDates){
                $query->whereBetween('sale_date', $payPeriodDates);
            },
            'countPayments' =>
            function($query) use($payPeriodId){
                $query->where('pay_period_id', '=', $payPeriodId);

            },
            'salary'
            ]

            )->orderBy('last_name')->get(['id','first_name','last_name']);

        $results = [];
        foreach($technicians as $technician){
            $payments = [];
            $result['count_payments'] = $technician->countPayments;
            $result['daily_sales'] = $technician->dailySales;
            $result['id'] = $technician->id;
            $result['salary_setup'] = $technician->salary;
            $result['total_sales_and_tips'] = $technician->totalSalesAndTips;
            $result['full_name'] = $technician->fullName;
            $result['first_name'] = $technician->first_name;

            if(count($technician->dailySales) > 0) {
                if ($technician->salary->payment_scheme == 'normal') {
                    array_push($payments,array('amount' => $technician->totalSalesAndTips[0]->total, 'reference' => '', 'method'=>$technician->salary->default_payment_method));
                }
                else if($technician->salary->payment_scheme == 'fixed'){
                    if($technician->totalSalesAndTips[0]->total > $technician->salary->default_payment_amount){
                        array_push($payments,array('amount' => $technician->salary->default_payment_amount,
                            'reference' => '', 'method' => $technician->salary->default_payment_method),
                            array('amount' => $technician->totalSalesAndTips[0]->total - $technician->salary->default_payment_amount,
                                'reference' => '', 'method' => 'check' ));
                    }
                    else{
                        array_push($payments,array('amount' => $technician->totalSalesAndTips[0]->total, 'reference' => '', 'method'=>$technician->salary->default_payment_method));
                    }

                }
                else if($technician->salary->payment_scheme == 'ratio'){
                    array_push($payments,array('amount' => $technician->totalSalesAndTips[0]->total * $technician->salary->check_ratio,
                        'reference' => '', 'method' => $technician->salary->default_payment_method),
                        array('amount' => $technician->totalSalesAndTips[0]->total - $technician->totalSalesAndTips[0]->total * $technician->salary->check_ratio,
                            'reference' => '', 'method' => 'check' ));
                }
            }

            $result['suggested_payments'] = $payments;

            array_push($results, $result);

        }

        return response()->json($results,200)->header('Content-type','application/json');
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

    public function searchWageByPeriod(PayPeriod $payPeriod, Technician $technician){

        $technicianId = $technician->id;

        $technician = Technician::with(['totalSalesAndTips' =>
            function($query) use ($payPeriod){

                $query->whereBetween('sale_date',[$payPeriod->begin_date, $payPeriod->end_date]);

            }])->where('id', '=', $technicianId)->first();


        return response()->json($technician->totalSalesAndTips,
            200);

    }

    public function searchPaymentByPeriod(PayPeriod $payPeriod, Technician $technician){
        $technicianId = $technician->id;
        $payPeriodId = $payPeriod->id;

        $payments = WagePayment::where('pay_period_id','=',$payPeriodId)->where('technician_id','=',$technicianId)->get();

        return response()->json($payments,200);
    }
}


