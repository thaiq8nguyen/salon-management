<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalonSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){


        return view('salon.sales-entry');

    }

    public function store(Request $request){


    }
}
