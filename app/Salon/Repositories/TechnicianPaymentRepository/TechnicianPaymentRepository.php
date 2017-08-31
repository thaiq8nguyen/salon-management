<?php
namespace Salon\Repositories\TechnicianPaymentRepository;

use App\Technician;
use App\PayPeriod;
use App\WagePayment;
use App\TechnicianBook;

class TechnicianPaymentRepository implements TechnicianPaymentRepositoryInterface{



    public function getPayments(Technician $technician, PayPeriod $payPeriod){

        $technicianId =  $technician->id;
        $payPeriodId = $payPeriod->id;

        return Technician::with(['payments' =>

            function($query) use($payPeriodId){
                $query->where('pay_period_id', '=', $payPeriodId);
            }])
            ->where('id', '=' ,$technicianId)

            ->first(['id','first_name','last_name']);

    }

    public function getPaymentsByDates($technicianId, $fromDate, $toDate)
    {
        return WagePayment::toTechnician($technicianId)->betweenDates([$fromDate,$toDate])->orderBy('pay_date')
            ->get(['id','technician_id','pay_period_id','amount','reference','method','pay_date','expense_account']);

    }

    public function deletePayment($paymentId, $payPeriodId, $technicianId)
    {

        $wagePayment = WagePayment::find($paymentId);

        $bookPayment = TechnicianBook::wages()->technician($technicianId)->payPeriod($payPeriodId)->first();

        $bookPayment->payments = $bookPayment->payments - $wagePayment->amount;

        $bookPayment->save();

        return WagePayment::destroy($paymentId);

    }
}