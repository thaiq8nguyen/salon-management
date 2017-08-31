<?php
namespace Salon\Repositories\TechnicianWageRepository;
use App\Technician;
use App\PayPeriod;

interface TechnicianWageRepositoryInterface{

    public function getWage(Technician $technician, Payperiod $payPeriod);

}