<?php
namespace App\Salon\PayPeriods;
interface PayPeriodInterface
{
    public function getCurrentPayPeriod();

    public function getFuturePayPeriods();

}
