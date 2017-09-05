<?php

namespace Salon\Repositories\PayDayRepository;

use App\PayPeriod;

interface PayDayRepositoryInterface{

    public function sales(PayPeriod $payPeriod);

    public function wage(PayPeriod $payPeriod);

    public function getPaymentSuggestions(PayPeriod $payPeriod);

    public function payday(PayPeriod $payPeriod);

    public function payTechnician($technicianId, $payPeriodId, $payments);
}