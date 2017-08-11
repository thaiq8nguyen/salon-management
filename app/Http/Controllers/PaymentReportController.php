<?php

namespace App\Http\Controllers;

use App\PayPeriod;
use App\Technician;
use App\TechnicianBook;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PaymentReportController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth','checkPayPeriod']);
    }

    public function show(Technician $technician, PayPeriod $payPeriod){


        $payPeriodID = $payPeriod->id;
        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];
        $technicianID = $technician->id;
        $technician = Technician::with(['dailySales' =>
            function($query) use ($payPeriodDates) {
                $query->whereBetween('sale_date', $payPeriodDates);
            },
            'totalSalesAndTips' =>
                function($query) use($payPeriodDates){
                    $query->whereBetween('sale_date', $payPeriodDates);
                }
        ])->with(['payments' =>

            function($query) use($payPeriodID){
                $query->where('pay_period_id', '=', $payPeriodID);
            }])
            ->where('id', '=' ,$technician->id)

            ->first(['id','first_name','last_name']);

        $book = TechnicianBook::balance()->groupBy('technician_id')->having('technician_id','=',$technicianID)->first();

        $pdf = PDF::loadView('pdf.payment', ['technician' => $technician,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy, 'book' => $book])
        ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);
        return $pdf->stream('payment.pdf');
    }
}
