<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WagePaymentController extends Controller
{
    public function pay(Technician $technician){

        return view('wages.pay-technician');

    }
}
