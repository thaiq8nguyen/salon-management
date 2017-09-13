<?php
namespace Salon\Repositories\TechnicianPaymentRepository;


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

    public function getPaymentSumByPayPeriod($technicianId, $payPeriodId)
    {
        $wagePayments = $this->getPaymentsByPayPeriod($technicianId, $payPeriodId);

        $paymentSum = 0.0;
        if(count($wagePayments) > 0){
            foreach($wagePayments as $wagePayment)
            {
                $paymentSum += $wagePayment->amount;
            }
        }


        return $paymentSum;

    }

    public function deletePayment($technicianId, $payPeriodId)
    {

        $wagePayments = WagePayment::toTechnician($technicianId)->payPeriod($payPeriodId)->get();

        foreach($wagePayments as $wagePayment){

            $wagePayment->delete();
        }


        $bookItems = TechnicianBook::technician($technicianId)->payPeriod($payPeriodId)->get();

        foreach($bookItems as $bookItem){

            $bookItem->delete();
        }

    }
}