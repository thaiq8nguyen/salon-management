<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalonSaleApiController extends Controller
{
    public function createSale(Request $request){
        return response()->json($request->input('grossSale'),200);
    }
}
