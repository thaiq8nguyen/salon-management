<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface;

class PaymentReportTestController extends Controller
{

    protected $report;

    public function __construct(PaymentReportRepositoryInterface $report)
    {
        $this->middleware('admin');
        $this->report = $report;
    }

    public function preview($technicianId, $payPeriodId){

        return $this->report->preview($technicianId, $payPeriodId);

    }
}
