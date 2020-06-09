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

    public function getPayPeriods(Request $request)
    {
        $query = $request->query('query');

        $payPeriods = '';
        if($query){
            if($query == 'current'){
                $payPeriods = $this->payPeriod->getPayPeriod(null);
            }
            if($query == 'standard'){
                $payPeriods = $this->payPeriod->getStandardPayPeriods();
            }

        }

        return $this->sendResponse(['name' => 'payPeriods', 'value' => $payPeriods]);
    }
}
