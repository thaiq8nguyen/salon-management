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
    public function __construct()
    {
        $this->middleware(['auth', 'checkPayPeriod']);
    }
    /**
     * Route: wage/pay/{technician}
     * Function: feed technician and sale date to pay-technician.blade.php
     * @param Technician $technician
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Technician $technician){

        $payPeriod = session()->get('payPeriod');

        $technicianID = $technician->id; //get the technician ID from the $technician parameter
        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];
        //store $technicianID to session for paying technician to pay that technician in the store method
        session()->put('payingTechnicianID', $technicianID);

        //get the technician along with her associated sale object using the $payPeriod above and the technician ID
        $technician = Technician::with(['dailySales' =>
                function($query) use ($payPeriodDates){
                    $query->whereBetween('sale_date',$payPeriodDates);
                },
                'totalSalesAndTips' =>
                    function($query) use($payPeriodDates) {
                        $query->whereBetween('sale_date', $payPeriodDates);
                    }
            ]
        )->where('id','=',$technicianID)->first(['id','first_name','last_name']);

        return view('wages.pay-technician',['technician' => $technician, 'payPeriod' =>$payPeriod->pay_period_mdy,
            'payDate' => $payPeriod->pay_date_mdy]);
    }

    /**
     * Validate and store wage page into the wage_payments table
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){

        if(!session()->has('payingTechnicianID')){
            return redirect()->route('payday');
        }

        $technician = Technician::find(session()->get('payingTechnicianID')); //get technician collection

        $payPeriod = session()->get('payPeriod');

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
            $payment['pay_period_id'] = $payPeriod->id;
            $payment['pay_date'] = Carbon::now()->toDateString();
            $payment['expense_account'] = 'wages';
            $payments[] = new WagePayment($payment);

        }
        //insert payments collection array into the wage_payments_table
        $technician->payments()->saveMany($payments);

        session()->put('wageAmount', $totalAmount);


        return redirect()->route('insert-wages-to-book');

    }

}
