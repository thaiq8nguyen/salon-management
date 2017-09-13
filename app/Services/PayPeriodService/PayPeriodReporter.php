<?php
namespace App\Services\PayPeriodService;

use Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface as Payment;
use Salon\Repositories\TechnicianSaleRepository\TechnicianSaleRepositoryInterface as Sale;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface as WageReport;



class PayPeriodReporter{

    protected $payment;
    protected $sale;
    protected $report;
    protected $technicianId;
    protected $payPeriodId;


    public function __construct(Payment $payment, Sale $sale, WageReport $report)
    {

        $this->payment = $payment;
        $this->sale =  $sale;
        $this->report = $report;

    }

    public function getReport($technicianId, $payPeriodId)
    {
        $this->technicianId = $technicianId;
        $this->payPeriodId = $payPeriodId;

        return ['pay_period_balance' => $this->getPayPeriodBalance(),
            'total_balance' => $this->getTotalBalance(),
        'wage_report_url' => $this->getReportUrl(),
        'wage_payment' => $this->getWagePayment()];
    }

    private function getPayPeriodBalance()
    {

        return $this->sale->getPayPeriodBalance($this->technicianId, $this->payPeriodId);

    }

    private function getTotalBalance()
    {

        return $this->sale->getTotalBalance($this->technicianId, $this->payPeriodId);

    }

    private function getReportUrl()
    {

        return $this->report->url($this->technicianId, $this->payPeriodId);

    }

    private function getWagePayment()
    {

        return $this->payment->getPaymentsByPayPeriod($this->technicianId, $this->payPeriodId);

    }

}