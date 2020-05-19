<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salon\PayPeriods\PayPeriodInterface;

class PayPeriodController extends BaseController
{
    protected $payPeriod;

    public function __construct(PayPeriodInterface $payPeriod)
    {
        $this->payPeriod = $payPeriod;
    }

    public function getPayPeriod(Request $request)
    {
        $hasQuery = $request->query('query');

        $payPeriods = '';
        if($hasQuery){
            if($hasQuery == 'current'){
                $payPeriods = $this->payPeriod->getCurrentPayPeriod();
            }
            else if($hasQuery == 'future'){
                $payPeriods = $this->payPeriod->getFuturePayPeriods();
            }
        }

        return $this->sendResponse(['name' => 'pay periods', 'value' => $payPeriods]);
    }
}
