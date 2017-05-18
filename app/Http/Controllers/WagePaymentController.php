<?php

namespace App\Http\Controllers;
use App\Technician;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;

class WagePaymentController extends Controller
{
    public function create(Technician $technician){
        $payPeriod = ['2017-04-29','2017-05-13'];
        $technicianID = $technician->id;

        $technician = Technician::with(['dailySales' =>
                function($query) use ($payPeriod){
                    $query->whereBetween('sale_date',$payPeriod);
                },
                'totalSales' =>
                    function($query) use($payPeriod){
                        $query->whereBetween('sale_date',$payPeriod);
                    },
                'totalTips' =>
                    function($query) use($payPeriod) {
                        $query->whereBetween('sale_date', $payPeriod);
                    }
            ]
        )->where('id','=',$technicianID)->get(['id','first_name','last_name']);

        return view('wages.pay-technician',['technician' => $technician]);
    }
    public function store(Request $request){

        $rules = [
            'payment.*.amount' => 'required|numeric|between:1,5000',
            'payment.*.reference' => 'nullable|min:3',
            'payment.*.method' => 'present'
        ];

        $payments = $request->all();
        if(count($payments['payment']) > 3){
            return redirect('wages/pay/Annie')->with('paymentsNumberError','The maximum number of payment is 3');
        }

        $validator = Validator::make($payments,$rules);
        if($validator->fails()){
            return redirect('wages/pay/Annie')->withErrors($validator);
        };
    }
}
