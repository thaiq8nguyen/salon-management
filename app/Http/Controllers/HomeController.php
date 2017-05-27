<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PayPeriod;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now()->toDateString();

        $payPeriod = PayPeriod::where([['begin_date','<=',$date],['end_date','>=', $date]])->first();

        session()->put('payPeriod', $payPeriod);

        return view('home');
    }
}
