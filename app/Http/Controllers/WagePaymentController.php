<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Services\PayPeriodService\TechnicianReporter as TechnicianReporter;
use Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface as Payment;


class WagePaymentController extends Controller
{
    protected $reporter;
    protected $payment;


    public function __construct(TechnicianReporter $reporter, Payment $payment)
    {
        $this->reporter = $reporter;
        $this->payment = $payment;
    }

    public function report(Request $request)
    {

        return response()->json($this->reporter->report($request->technicianId, $request->payPeriodId),200);

    }

    public function deletePayment(Request $request){

        $this->payment->deletePayment($request->technicianId, $request->payPeriodId);

        return response()->json(['success' => true], 200);

    }



}
