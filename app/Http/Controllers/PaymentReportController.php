<?php

namespace App\Http\Controllers;

use App\PayPeriod;
use App\Technician;
use App\TechnicianBook;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class PaymentReportController extends Controller
{
    public function show(Technician $technician, PayPeriod $payPeriod){
        //var_dump($payPeriod->begin_date_mdy);

        $periodID = $payPeriod->id;
        $period = [$payPeriod->begin_date, $payPeriod->end_date];

        $technician = Technician::with(['dailySales' =>
            function($query) use ($period) {
                $query->whereBetween('sale_date', $period);
            },
            'totalSalesAndTips' =>
                function($query) use($period){
                    $query->whereBetween('sale_date', $period);
                }
        ])->with(['payments' =>

            function($query) use($periodID){
                $query->where('pay_period_id', '=', $periodID);
            }])
            ->where('id', '=' ,$technician->id)

            ->first(['id','first_name','last_name']);

        $book = TechnicianBook::where('pay_period_id', '=', $periodID)->first(['balance']);

        //return view('pdf.payment', ['technician' => $technician, 'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy]);
        $pdf = PDF::loadView('pdf.payment', ['technician' => $technician,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy, 'book' => $book])
        ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);
        return $pdf->stream('payment.pdf');
    }
}
