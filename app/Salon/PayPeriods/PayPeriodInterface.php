<?php
namespace App\Salon\PayPeriods;
interface PayPeriodInterface
{
    public function getStandardPayPeriods();

    public function getPayPeriod($payPeriodId);

    public function getAllTechnicianSales($payPeriodId);

    public function getTechnicianSales($payPeriodId, $technicianId);

    public function getAllTechnicianEarnings($payPeriodId);

    public function getTechnicianEarning($payPeriodId, $technicianId);



}
