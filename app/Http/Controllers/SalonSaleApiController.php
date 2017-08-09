<?php

namespace App\Http\Controllers;
use App\SalonSale;
use App\TechnicianSale;
use App\SalonSaleDetails;

use Salon;

use Illuminate\Http\Request;


class SalonSaleApiController extends Controller
{
    public function getDailySales(Request $request){

        $date =  $request->input('date');
        $result = Salon::getDailySales($date);

        return response()->json($result,200)->header('Content-type', 'application/json');
    }

    public function redeemGiftCertificate(Request $request){
        $date = $request->input('date');
        $amount =  $request->input('amount');

        $result = Salon::redeemGift($date, $amount);


        return response()->json($result,200)->header('Content-type','application/json');
    }

    public function sync(){

        $sales = Salon::getSquareDailySaleMetrics();

    }
}

