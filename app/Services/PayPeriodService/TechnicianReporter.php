<?php
namespace App\Services\PayPeriodService;

use Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface as Payment;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface as Report;

class TechnicianReporter{

    protected $payment;
    protected $report;

    public function __construct(Payment $payment, Report $report)
    {
        $this->payment = $payment;
        $this->report = $report;
    }

    public function report($technicianId, $payPeriodId){


        return ['pay_period' => $this->report->url($technicianId, $payPeriodId),
            'payments' => $this->payment->getPaymentsByPayPeriod($technicianId, $payPeriodId) ];

    }




    
}