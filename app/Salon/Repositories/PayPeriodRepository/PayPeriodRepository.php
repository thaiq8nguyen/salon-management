<?php
namespace Salon\Repositories\PayPeriodRepository;
use App\PayPeriod;

class PayPeriodRepository implements PayPeriodRepositoryInterface {

    protected $payPeriod;

    public function __construct(PayPeriod $payPeriod)
    {
        $this->payPeriod = $payPeriod;
    }


    public function getCurrentPayPeriodId()
    {
        $this->payPeriod = PayPeriod::select('begin_date','end_date')->latest()->first();

        return $this->payPeriod->id;

    }


    public function getPreviousPayPeriodId()
    {
        $this->getCurrentPayPeriodId();

        $currentPayPeriodId = $this->payPeriod->id;

        $previousPayPeriod = PayPeriod::where('id','<', $currentPayPeriodId)
            ->orderBy('id','desc')->limit(1)->first();

        return $previousPayPeriod->id;
    }
}