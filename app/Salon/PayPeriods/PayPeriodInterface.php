<?php
namespace App\Salon\PayPeriods;
interface PayPeriodInterface
{
    public function getStandardPayPeriods();

    public function getPayPeriod($payPeriodId);

    public function getAllTechnicianSales($payPeriodId);

    public function getTechnicianSales($payPeriodId, $technicianId);

    public function getTechnicianEarnings($payPeriodId);



}
