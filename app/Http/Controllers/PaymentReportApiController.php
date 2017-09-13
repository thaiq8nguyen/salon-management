<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface;

class PaymentReportApiController extends Controller
{
    protected $report;
    public function __construct(PaymentReportRepositoryInterface $report)
    {
        $this->report = $report;

    }

    public function byTechnician(Request $request){

        return response()->json($this->report->listReports($request->technicianId),200);

    }


}
