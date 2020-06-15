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

    public function getAllTechnicianSales($payPeriodId)
    {

        $technicianSales = $this->payPeriod->getAllTechnicianSales($payPeriodId);
        return $this->sendResponse(['name' => 'technicianSales', 'value' => $technicianSales]);
    }

    public function getTechnicianSales($payPeriodId, $technicianId)
    {
        $technicianSale = $this->payPeriod->getTechnicianSales($payPeriodId, $technicianId);
        return $this->sendResponse(['name' => 'technicianSale', 'value' => $technicianSale]);
    }


    public function getAllTechnicianEarnings($payPeriodId)
    {
        $technicianEarnings = $this->payPeriod->getAllTechnicianEarnings($payPeriodId);
        return $this->sendResponse(['name' => 'technicianEarnings', 'value' => $technicianEarnings]);

    }

    public function getTechnicianEarning($payPeriodId, $technicianId)
    {
        $technicianEarning = $this->payPeriod->getTechnicianEarning($payPeriodId, $technicianId);

        return $this->sendResponse((['name' => 'technicianEarning', 'value' => $technicianEarning]));
    }


}
