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
            ->limit(3)->orderBy('pay_date', 'desc')->get()->reverse()->values();

        return $previousPayPeriods;
    }

    public function getPayPeriod($payPeriodId = null)
    {
        $today = Carbon::now()->toDateString();

        $payPeriod = PayPeriod::where('id', $payPeriodId)->first();


        if (is_null($payPeriodId)) {
            $payPeriod = PayPeriod::where([['begin_date', '<=', $today], ['end_date', '>=', $today]])->first();
        }

        return $payPeriod;
    }

    public function getAllTechnicianSales($payPeriodId)
    {
        $payPeriod = $this->getPayPeriod($payPeriodId);

        $dateFilter = function ($query) use ($payPeriod) {
            $query->whereBetween('date', [$payPeriod->beginDate, $payPeriod->endDate])->orderBy('date', 'asc')
                ->groupBy(['date', 'transactionable_id']);
        };

        $technicians = Technician::with([
            'sales' => $dateFilter
        ])->whereHas('sales', $dateFilter)->get();

        return ['payPeriodId' => $payPeriodId, 'technicians' => $technicians];

    }

    public function getTechnicianSale($payPeriodId, $technicianId)
    {
        $payPeriod = $this->getPayPeriod($payPeriodId);

        $dateFilter = function ($query) use ($payPeriod) {
            $query->whereBetween('date', [$payPeriod->beginDate, $payPeriod->endDate])->orderBy('date', 'asc')
                ->groupBy(['date', 'transactionable_id']);
        };

        $technician = Technician::with([
            'sales' => $dateFilter
        ])->whereHas('sales', $dateFilter)->where('id', $technicianId)->first();

        return $technician;
    }

    public function getAllTechnicianEarnings($payPeriodId)
    {
        $technicians = $this->getAllTechnicianSales($payPeriodId);
        $payPeriod = $this->getPayPeriod($payPeriodId);

        $earnings = ['payPeriodName' => $payPeriod->name, 'payPeriodId' => $payPeriod->id, 'technicians' => []];
        if ($technicians) {
            foreach ($technicians['technicians'] as $technician) {
                $technicianId = $technician['technicianId'];
                $result = [
                    'technicianId' => $technician->technicianId,
                    'totalSale' => $technician->sales->where('name', 'technician sales')
                        ->sum('creditAmount'),
                    'totalTip' => $technician->sales->where('name', 'technician tips')
                        ->sum('creditAmount'),
                    'rates' => [
                        "commissionRate" => Technician::find($technicianId)->detail->commissionRate,
                        "tipRate" => Technician::find($technicianId)->detail->tipRate
                    ],
                    'saleWage' => round($technician->sales->where('name', 'technician sales')
                            ->sum('creditAmount') * Technician::find($technicianId)->detail->commissionRate, 2),
                    'tipWage' => round($technician->sales->where('name', 'technician tips')
                            ->sum('creditAmount') * Technician::find($technicianId)->detail->tipRate, 2)
                ];

                $results[] = $result;
                $earnings['technicians'] = $results;
            }

        }

        return $earnings;
    }

    public function getTechnicianEarning($payPeriodId, $technicianId)
    {
        $payPeriod = $this->getPayPeriod($payPeriodId);
        $technician = $this->getTechnicianSale($payPeriodId, $technicianId);

        $earning = [
            'payPeriodName' => $payPeriod->name,
            'payPeriodId' => $payPeriod->id,
            'technicianId' =>
                $technician->technicianId,
            'totalSale' => round($technician->sales->where('name', 'technician sales')
                ->sum('creditAmount'), 2),
            'totalTip' => round($technician->sales->where('name', 'technician tips')
                ->sum('creditAmount'), 2),
            'rates' => [
                "commissionRate" => Technician::find($technicianId)->detail->commissionRate,
                "tipRate" => Technician::find($technicianId)->detail->tipRate
            ],
            'saleWage' => round($technician->sales->where('name', 'technician sales')
                    ->sum('creditAmount') * Technician::find($technicianId)->detail->commissionRate, 2),
            'tipWage' => round($technician->sales->where('name', 'technician tips')
                    ->sum('creditAmount') * Technician::find($technicianId)->detail->tipRate, 2)
        ];


        return $earning;

    }

    public function payTechnician($payPeriodId, $payments)
    {
        // TODO: Implement payTechnician() method.
    }


}
