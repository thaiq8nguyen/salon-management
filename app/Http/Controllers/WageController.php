<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TechnicianSale;
use App\Technician;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\PayPeriod;
class WageController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    /**Route: /wages/pay
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payday(){

        return view('wages.payday',['pageTitle' => 'Payday']);
    }


}
