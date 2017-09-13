<?php

namespace App\Http\Controllers;

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





}
