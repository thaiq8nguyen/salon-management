<?php

namespace Salon\Repositories\TechnicianSaleRepository;
use App\Technician;
use App\PayPeriod;
use App\TechnicianBook;


class TechnicianSaleRepository implements TechnicianSaleRepositoryInterface {


    /**
     * Return technician's sale including sale_date, sale, and tips
     * @param Technician $technician
     * @param PayPeriod $payPeriod
     * @return mixed
     */
    public function getSales(Technician $technician, PayPeriod $payPeriod){

        $dates= [$payPeriod->begin_date, $payPeriod->end_date];
        $technicianId = $technician->id;

        return Technician::with(['dailySales' =>
            function($query) use ($dates)
            {
                $query->whereBetween('sale_date', $dates);
            }])
            ->where('id','=',$technicianId)

            ->first(['id','first_name','last_name']);

    }

    /**
     * Return technician book pay period balance for a particular pay period
     * @param Technician $technician
     * @param PayPeriod $payPeriod
     * @return mixed
     */
    public function getPayPeriodBalance(Technician $technician, PayPeriod $payPeriod){

        $payPeriodId = $payPeriod->id;
        $technicianId = $technician->id;

        return TechnicianBook::periodBalance()->where('technician_id','=',$technicianId)->groupBy('pay_period_id')->
        having('pay_period_id','=',$payPeriodId)->first();

    }

    /**
     * Return technician book total balance from the first pay period until a given pay period
     * @param Technician $technician
     * @param PayPeriod $payPeriod
     * @return mixed
     */
    public function getTotalBalance(Technician $technician, PayPeriod $payPeriod){

        $payPeriodId = $payPeriod->id;
        $technicianId = $technician->id;

        return $totalBalance = TechnicianBook::totalBalance()->
        where('technician_id','=',$technicianId)->where('pay_period_id','<=',$payPeriodId)->first();

    }





}