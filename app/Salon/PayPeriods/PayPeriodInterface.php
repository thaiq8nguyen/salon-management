<?php
namespace App\Salon\PayPeriods;
interface PayPeriodInterface
{
    public function getStandardPayPeriods();

    public function getPayPeriod($payPeriodId);

    public function getTechnicianSales($payPeriodId);



}
