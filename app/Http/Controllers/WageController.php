<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TechnicianSale;
use App\Technician;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DB;
class WageController extends Controller
{
    public function payday(){

        $payPeriod = ['2017-04-29','2017-05-13'];

        $technicians = Technician::with(['dailySales' =>
                function($query) use ($payPeriod){
                    $query->whereBetween('sale_date',$payPeriod);
                },
                'totalSales' =>
                    function($query) use($payPeriod){
                        $query->whereBetween('sale_date',$payPeriod);
                },
                'totalTips' =>
                    function($query) use($payPeriod) {
                        $query->whereBetween('sale_date', $payPeriod);
                    }
            ]
            )->whereHas('sales')->get(['id','first_name','last_name']);

        return view('wages.payday',['technicians'=> $technicians]);
    }


}
