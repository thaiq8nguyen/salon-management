<?php

namespace App\Http\Controllers;
use App\Technician;
use App\PayPeriod;
use App\TechnicianBook;
use Request;
use Barryvdh\DomPDF\Facade as PDF;

use Salon\Repositories\TechnicianSaleRepository\TechnicianSaleRepositoryInterface;
use Salon\Repositories\TechnicianWageRepository\TechnicianWageRepositoryInterface;
use Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface;

class PaymentReportController extends Controller
{
    protected $sales;
    protected $wage;
    protected $payments;
    protected $paymentReport;
    public function __construct(TechnicianSaleRepositoryInterface $sales,
                                TechnicianWageRepositoryInterface $wage,
                                TechnicianPaymentRepositoryInterface $payments)
    {
        $this->middleware('auth');
        $this->sales = $sales;
        $this->wage = $wage;
        $this->payments = $payments;
    }


    public function create(Technician $technician, PayPeriod $payPeriod)
    {

        $technicianSales = $this->sales->getSales($technician, $payPeriod);
        $technicianWage =  $this->wage->getWage($technician, $payPeriod);
        $technicianPayment = $this->payments->getPayments($technician, $payPeriod);
        $totalBalance = $this->sales->getTotalBalance($technician, $payPeriod);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technician, $payPeriod);

        $pdf = PDF::loadView('pdf.payment', ['technician' => $technician, 'dailySales'=>$technicianSales,'totalSalesAndTips'=>$technicianWage
            ,'payments'=>$technicianPayment,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy,
            'totalBalance' => $totalBalance, 'periodBalance' => $payPeriodBalance])
            ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);

        return $pdf->stream('payment_report.pdf');

    }

    public function balance(PayPeriod $payPeriod,Technician $technician){

        $totalBalance = $this->sales->getTotalBalance($technician, $payPeriod);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technician, $payPeriod);

        return response()->json(['total_balance'=> $totalBalance, 'pay_period_balance' => $payPeriodBalance]);



    }


}
