<?php

namespace App\Http\Controllers;
use App\Technician;
use Illuminate\Http\Request;
use Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface;
use Validator;




class WagePaymentController extends Controller
{
    protected $payment;
    public function __construct(TechnicianPaymentRepositoryInterface $payment)
    {
        $this->middleware('admin');
        $this->payment = $payment;

    }

    public function getPaymentByDates(Request $request){

        $payments = $this->payment->getPaymentsByDates($request->technicianId, $request->from, $request->to);
        return response()->json($payments, 200);


    }

    public function deletePayment(Request $request){

        $deletedPayment = $this->payment->deletePayment($request->paymentId, $request->payPeriodId, $request->technicianId);

        return response()->json($deletedPayment, 200);

    }



}
