<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Technician;
use App\TechnicianSale;
use Validator;
use App\PayPeriod;

class TechnicianSaleController extends Controller
{
    //
    public function index(){
        //retrieve the current pay period from the PayPeriod model using a static method
        $payPeriod = PayPeriod::create();
        //insert pay schedule into the database if it's not already existed
        session()->flush();
        $period = PayPeriod::firstOrCreate($payPeriod); //collection

        session()->put('periodID', $period->id);

        $technicians = Technician::orderBy('last_name', 'asc')->select('first_name','last_name')->get();
        //var_dump($period->pay_date_mdy);

        return view('technicians.sales', ['technicians' => $technicians, 'payPeriod' => $period->pay_period_mdy, 'payDate' => $period->pay_date_mdy]);

    }


    /**
     * Route: /technician-sale/create/{technician}
     * @param Technician $technician
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Technician $technician){

        $period = PayPeriod::find(session()->get('periodID')); //get period collection

        $technicianID = $technician->id; //get technician ID

        $technician = Technician::with(['dailySales' =>
            function($query) use ($period){

                $query->whereBetween('sale_date',[$period->begin_date, $period->end_date]);

            }])->where('id', '=', $technicianID)->first(['id','first_name', 'last_name']);

        return view('technicians.create-sales', ['technician' => $technician, 'payPeriod'=>$period->pay_period_mdy, 'payDate' =>$period->pay_date_mdy]);

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
            return redirect('technician-sale/create/'.$technician->first_name)->withErrors($validator);
        }

        $sale = new TechnicianSale;

        $sale->technician_id = $request->input('technicianID');
        $sale->sale_date = $saleDate;
        $sale->sales = $request->input('sale');
        $sale->additional_sales = $request->input('additional-sale');

        $sale->save();

        $request->session()->flash('confirm-sale', 'Sale has been added for ' . $saleDate);
        return redirect('/technician-sale/create/'.$technician->first_name);

    }

    public function changeSale(Request $request){

        $validator =  Validator::make($request->all(),[
            'sale-id' =>'required',
            'sale' => 'nullable|numeric|between:1,1000',
            'additional-sale' => 'nullable|numeric|between:1,1000'
        ]);

        if($validator->fails()){
            $errors = $validator->getMessageBag();
            return response()->json(['success' => false, 'message' => $errors],422)
                ->header('Content-type', 'application/json');
        }

        $sale = TechnicianSale::find($request->input('sale-id'));

        if($request->has('sale')){
            $sale->sales = $request->input('sale');
        }
        if($request->has('additional-sale')){
            $sale->additional_sales = $request->input('additional-sale');
        }
        $saleDate = $sale->sale_date_mdy;

        $sale->update();

        return response()->json(['success' => true, 'message' => 'Sale has been updated for ' . $saleDate,
            'sale' => $sale->sales_amount, 'additionalSale' => $sale->additional_sales_amount],200)
            ->header('Content-type', 'application/json');

    }

    public function searchByDate(Request $request){

        $technicianID =  $request->input('technicianID');
        $saleDate = $request->input('saleDate');

        $sale = TechnicianSale::where([['technician_id','=',$technicianID],['sale_date','=', $saleDate]])->get();


        return response()->json(['success' => true, 'message' => $sale],200)->header('Content-type', 'application/json');

    }

}
