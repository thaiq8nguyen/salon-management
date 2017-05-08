<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician;

class TechnicianSaleController extends Controller
{
    //

    public function index(){


    }

    public function create(){

        $technicians = Technician::all();

        return view('technician-sale', ['technicians' => $technicians]);
    }

    public function store(Request $request){

    }
}
