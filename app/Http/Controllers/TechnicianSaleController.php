<?php

namespace App\Http\Controllers;

use App\TechnicianBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Technician;
use App\TechnicianSale;
use Validator;
use App\PayPeriod;

class TechnicianSaleController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','checkPayPeriod']);//checkPayPeriod middleware check for existing payPeriod collection in the session
    }
    //
    /**Route: /technician-sale
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $payPeriod = session()->get('payPeriod');

        $technician = Technician::all()->first();

        return view('technicians.sales', ['technician' => $technician, 'payPeriodDates' => $payPeriod->pay_period_mdy,
            'payDate' => $payPeriod->pay_date_mdy]);

    }


    /**
     * Route: /technician-sale/create
     * @param $saleDate
     * @param Technician $technician
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($saleDate, Technician $technician){

        $payPeriod = session()->get('payPeriod');

        $technicianID = $technician->id; //get technician ID

        $technician = Technician::with(['dailySales' =>
            function($query) use ($payPeriod){

                $query->whereBetween('sale_date',[$payPeriod->begin_date, $payPeriod->end_date]);

            }])->withCount(['sales'=>
                function($query) use ($saleDate){
                    $query->where('sale_date', $saleDate);
                }])->
            where('id', '=', $technicianID)->first(['id','first_name', 'last_name']);

        return view('technicians.create-sales', ['tech'=>$technician,'payPeriod'=>$payPeriod->pay_period_mdy,
            'payDate' =>$payPeriod->pay_date_mdy, 'saleDate' => $saleDate]);

    }
    public function storeSale(Request $request){

       $validator =  Validator::make($request->all(),[
            'sale-date' =>'required|date',
            'sale' => 'required|numeric',
            'additional-sale' => 'numeric'
        ]);

        $technician = Technician::find($request->input('technicianID'));

        $saleDate = $request->input('sale-date');

        if($validator->fails()){
            return redirect('/technician-sale/date/'.$saleDate .'/technician/'.$technician->first_name)->withErrors($validator);
        }

        $sale = TechnicianSale::create(['technician_id' => $request->input('technicianID'),'sale_date' => $saleDate,
            'sales' => $request->input('sale') ,'additional_sales' => $request->input('additional-sale')]);

        $request->session()->flash('confirm-sale', 'Sale has been added for ' . $sale->sale_date_mdy);
        return redirect('/technician-sale/date/'.$saleDate .'/technician/'.$technician->first_name);

    }

}
