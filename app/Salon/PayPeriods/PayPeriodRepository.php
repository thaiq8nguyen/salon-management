<?php

namespace App\Salon\PayPeriods;


use App\PayPeriod;
use App\Technician;
use App\Transaction;


use Carbon\Carbon;

class PayPeriodRepository implements PayPeriodInterface
{
    protected $payPeriod;

    public function __construct(PayPeriod $payPeriod)
    {
        $this->payPeriod = $payPeriod;
    }

    public function getStandardPayPeriods()
    {
        $currentPayPeriod = $this->getPayPeriod();
        $previousPayPeriods = PayPeriod::where('pay_date', '<=', $currentPayPeriod->payDate)
            ->limit(3)->orderBy('pay_date', 'desc')->select([
                'id',
                'begin_date AS beginDate',
                'end_date AS endDate',
                'pay_date AS payDate'
            ])->get()->reverse()->values();

        return $previousPayPeriods;
    }

    public function getPayPeriod($payPeriodId = null)
    {
        $today = Carbon::now()->toDateString();

        $payPeriod = PayPeriod::where('id', $payPeriodId)->select([
            'id',
            'begin_date AS beginDate',
            'end_date AS endDate',
            'pay_date AS payDate'
        ])->first();


        if (is_null($payPeriodId)) {
            $payPeriod = PayPeriod::where([['begin_date', '<=', $today], ['end_date', '>=', $today]])
                ->select(['id', 'begin_date AS beginDate', 'end_date AS endDate', 'pay_date AS payDate'])->first();
        }

        return $payPeriod;
    }

    public function getTechnicianSales($payPeriodId)
    {
        $payPeriod = $this->getPayPeriod($payPeriodId);

        $dateFilter = function($query) use ($payPeriod){
            $query->whereBetween('date', [$payPeriod->beginDate, $payPeriod->endDate])->orderBy('date', 'asc')
                ->groupBy(['date','transactionable_id']) ;
        };

        $technicians = Technician::with([
            'sales' => $dateFilter
        ])->whereHas('sales', $dateFilter)->get();






        return $technicians;

    }


}
