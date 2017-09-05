<?php

namespace App\Http\Controllers;
use App\Technician;
use App\PayPeriod;
use Illuminate\Http\Request;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface;

class PaymentReportController extends Controller
{
    protected $report;

    public function __construct(PaymentReportRepositoryInterface $report)
    {
        $this->middleware('auth');
        $this->report = $report;

    }

    public function index(){

        return view('technicians.payment-reports');
    }


    public function all()
    {
        return response()->json($this->report->all(),200);


    }

    public function create(Request $request){

        $url = $this->report->create($request->technicianId, $request->payPeriodId);

        if(isset($url)){
            $result = ['success' => true, 'message' => 'The report has been created'];
        }
        else{
            $result = ['success' => false];
        }

        return response()->json($result,200);

    }

    public function show(Request $request){


    }



    public function balance(PayPeriod $payPeriod,Technician $technician){

        $totalBalance = $this->sales->getTotalBalance($technician, $payPeriod);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technician, $payPeriod);

        return response()->json(['total_balance'=> $totalBalance, 'pay_period_balance' => $payPeriodBalance]);



    }


}
