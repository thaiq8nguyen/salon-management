<?php
namespace Salon\Repositories\TechnicianPaymentRepository;


interface TechnicianPaymentRepositoryInterface{

    public function getPaymentsByPayPeriod($technicianId, $payPeriodId);

    public function getPaymentsByDates($technicianId, $fromDate, $toDate);

    public function deletePayment($paymentId, $payPeriodId, $technicianId);

}