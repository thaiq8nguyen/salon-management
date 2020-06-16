<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;

class PaymentMethodController extends BaseController
{
    public function getAllPaymentMethods()
    {
        $paymentMethods = PaymentMethod::all();

        return $this->sendResponse(['name' => 'paymentMethods', 'value' => $paymentMethods]);

    }
}
