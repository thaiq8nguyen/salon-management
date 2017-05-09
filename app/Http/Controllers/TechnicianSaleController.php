<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician;
use App\TechnicianSale;
use Validator;
use DateTime;



class TechnicianSaleController extends Controller
{
    //

    public function index(){


    }

    public function showAllTechnician(){

        $technicians = Technician::all();

        return view('technicians.sales', ['technicians' => $technicians]);
    }

    /**
     * @param Technician $technician
     * @return $this
     * @property $technician->first_name
     */
    public function createSale(Technician $technician){

        $data = ['firstName' => $technician->first_name,
                    'lastName' => $technician->last_name,
                    'id' => $technician->id];

        return view('technicians.create-sales')->with($data);
    }
    public function storeSale(Request $request){

        $validator =  Validator::make($request->all(),[
            'sale-date' =>'required|date',
            'sale' => 'required|numeric',
            'additional-sale' => 'numeric'

        ]);

        $technician = Technician::find($request->input('technicianID'));
        $name = $technician->first_name . ' ' . $technician->last_name;

        if($validator->fails()){
            return redirect('technician-sale/create/'.$technician->first_name)->withErrors($validator);
        }

        $sale = new TechnicianSale;
        $date = new DateTime($request->input('sale-date'));

        $sale->technician_id = $request->input('technicianID');
        $sale->sale_date = $date->format('Y-m-d');
        $sale->sales = $request->input('sale');
        $sale->additional_sales = $request->input('additional-sale');

        $sale->save();

        $request->session()->flash('confirm-sale', 'Sale has been added for ' . $name);
        return redirect('technician-sale/show');



    }
}
