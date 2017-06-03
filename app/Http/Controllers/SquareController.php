<?php

namespace App\Http\Controllers;

use Salon\Square\Square;
use Salon\Sales\Salon;

class SquareController extends Controller
{
    public function getLocation(){

        $result = Square::getLocation();

        return response()->json($result);

    }

    public function getSaleMetrics(){

        Salon::getDailySaleMetrics();

    }




}
