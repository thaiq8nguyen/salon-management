<?php

namespace App\Http\Controllers;
use App\Technician;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\PayPeriod;
use App\WagePayment;


class WagePaymentController extends Controller
{
    /**
     * Route: wage/pay/{technician}
     * Function: feed technician and sale date to pay-technician.blade.php
     * @param Technician $technician
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Technician $technician){
        $periodID = session()->get('periodID'); //get the payPeriodID
        $period = PayPeriod::find($periodID); //get the period collection

        $payPeriod = [$period['begin_date'],$period['end_date']]; //construct the array containing the begin, and end dates
        $technicianID = $technician->id; //get the technician ID from the $technician parameter

        //store $technicianID to session for paying technician to pay that technician in the store method
        session()->put('payingTechnicianID', $technicianID);

        //get the technician along with her associated sale object using the $payPeriod above and the technician ID
        $tech = Technician::with(['dailySales' =>
                function($query) use ($payPeriod){
                    $query->whereBetween('sale_date',$payPeriod);
                },
                'totalSalesAndTips' =>
                    function($query) use($payPeriod) {
                        $query->whereBetween('sale_date', $payPeriod);
                    }
            ]
        )->where('id','=',$technicianID)->first(['id','first_name','last_name']);


        return view('wages.pay-technician',['technician' => $tech]);
    }

    /**
     * Validate and store wage page into the wage_payments table
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $technician = Technician::find(session()->get('payingTechnicianID')); //get technician collection
        $periodID = session()->get('periodID'); //get the period id

        //validation rules
        $rules = [
            'payments.*.amount' => 'required|numeric|between:1,5000',
            'payments.*.reference' => 'nullable|min:3',
            'payments.*.method' => 'present'
        ];
        //get all the inputs except the token input
        $paymentsInput = $request->all();
        //var_dump($paymentsInput);

        //the validation rule permits only 3 or less payments
        if(count($paymentsInput['payments']) > 3){
            return redirect('wages/pay/'.$technician->first_name)->with('paymentsNumberError','The maximum number of payment is 3');
        }

        //the validation rule specified above is apply to each input the array
        $validator = Validator::make($paymentsInput,$rules);
        if($validator->fails()){
            return redirect('wages/pay/'.$technician->first_name)->withErrors($validator);
        };

        //the loop construct to create an array of WagePayment collection including pay_period_id, pay_date, and expense_account
        $payments = [];
        $totalAmount = 0.0;
        foreach($paymentsInput['payments'] as $payment){
            $totalAmount += $payment['amount'];
            $payment['pay_period_id'] = $periodID;
            $payment['pay_date'] = Carbon::now()->toDateString();
            $payment['expense_account'] = 'wages';
            $payments[] = new WagePayment($payment);

        }
        //insert payments collection array into the wage_payments_table
        $technician->payments()->saveMany($payments);
        session()->pull('payTechnicianID'); //remove the technicianID from a session variable

        //call the method to insert the pay record into technician_books table
        $this->insertPaymentToBook($technician->id,$periodID,Carbon::now()->toDateString(),'wages',$totalAmount);
        //redirect to the pay dashboard
        $request->session()->flash('success-pay',$technician->first_name .' had been paid!');

        return redirect('/wages/pay');

    }
    private function insertPaymentToBook($technicianID, $payPeriodID, $payDate, $description, $pay){

        $data = DB::table('technician_books')->select('balance')->where('technician_id','=',$technicianID)
            ->latest('date')->first();

        $balance = $data->balance - $pay;
        DB::table('technician_books')->insert(
            ['technician_id' => $technicianID, 'pay_period_id' => $payPeriodID, 'date' => $payDate,
                'description' => $description, 'pay' => $pay, 'balance' => $balance,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()]
        );


    }
}
