<?php
namespace Salon\Repositories\TechnicianWageRepository;

use App\PayPeriod;
use App\Technician;

class TechnicianWageRepository implements TechnicianWageRepositoryInterface {

    protected $wage;

    public function getWage(Technician $technician, PayPeriod $payPeriod){

        $technicianId = $technician->id;
        $dates= [$payPeriod->begin_date, $payPeriod->end_date];

        return Technician::with(['totalSalesAndTips' =>
            function($query) use ($dates)
            {
                $query->whereBetween('sale_date', $dates);
            }])
            ->where('id','=',$technicianId)

            ->first(['id','first_name','last_name']);

    }

    public function getTotalWageByPayPeriod($technicianId, $payPeriodId)
    {
        $payPeriod = PayPeriod::find($payPeriodId);

        $dates= [$payPeriod->begin_date, $payPeriod->end_date];

        return Technician::with(['totalWage' =>
            function($query) use ($dates)
            {
                $query->whereBetween('sale_date', $dates);
            }])
            ->where('id','=', $technicianId)

            ->first(['id']);
    }


}


