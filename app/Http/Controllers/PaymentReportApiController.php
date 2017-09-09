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

        return response()->json($this->report->listReports($request->technicianId, $request->months),200);

    }

    public function update(Request $request){

        return response()->json($this->report->update($request->technicianId, $request->payPeriodId),200);

    }
}
