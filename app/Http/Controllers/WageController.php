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
        $data = Technician::with(['sales' =>
            function($query){
                    $query->whereBetween('sale_date',['2017-04-29','2017-05-13']);
            }])->get(['id','first_name','last_name']);





        return view('wages.pay',['data'=> $data ]);
    }

}
