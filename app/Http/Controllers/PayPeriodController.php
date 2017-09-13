<?php

namespace App\Http\Controllers;

use App\PayPeriod;
use Illuminate\Http\Request;

class PayPeriodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function report()
    {
        return view('wages.report');
    }

}
