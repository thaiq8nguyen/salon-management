<?php
namespace Salon\Repositories\TechnicianSaleRepository;
use App\Technician;
use App\PayPeriod;
interface TechnicianSaleRepositoryInterface{

    public function getSales(Technician $technician, PayPeriod $payPeriod);

    public function getPayPeriodBalance(Technician $technician, PayPeriod $payPeriod);

    public function getTotalBalance(Technician $technician, PayPeriod $payPeriod);


}