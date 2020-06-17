<?php
namespace App\Salon\PayPeriods;
interface PayPeriodInterface
{
    public function getStandardPayPeriods();

    public function getPayPeriod($payPeriodId);

    public function getAllTechnicianSales($payPeriodId);

    public function getTechnicianSale($payPeriodId, $technicianId);

    public function getAllTechnicianEarnings($payPeriodId);

    public function getTechnicianEarning($payPeriodId, $technicianId);

    public function payTechnician($payPeriodId, $payments);



}
