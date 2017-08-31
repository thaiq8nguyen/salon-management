<?php
namespace Salon\Repositories\TechnicianPaymentRepository;
use App\Technician;
use App\PayPeriod;

interface TechnicianPaymentRepositoryInterface{

    public function getPayments(Technician $technician, PayPeriod $payPeriod);

    public function getPaymentsByDates($technicianId, $fromDate, $toDate);

    public function deletePayment($paymentId, $payPeriodId, $technicianId);

}