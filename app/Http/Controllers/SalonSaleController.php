<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalonSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(){

        return view('salon.salon-sales')->with('pageTitle','Salon Sales');

    }



}
