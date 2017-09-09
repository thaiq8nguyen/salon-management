<?php
namespace Salon\Repositories\TechnicianPaymentRepository;

use App\Technician;
use App\PayPeriod;
use App\Wage;
use App\WagePayment;
use App\TechnicianBook;

class TechnicianPaymentRepository implements TechnicianPaymentRepositoryInterface{



    public function getPaymentsByPayPeriod($technicianId, $payPeriodId){

        return WagePayment::toTechnician($technicianId)->where('pay_period_id','=',$payPeriodId)->get(['id','amount','method','reference']);

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