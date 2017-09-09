<?php
namespace Salon\Repositories\PayPeriodRepository;

interface PayPeriodRepositoryInterface{

    public function getWagePayment($technicianId, $payPeriodId);

}