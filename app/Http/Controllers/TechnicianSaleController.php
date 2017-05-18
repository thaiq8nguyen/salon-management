<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Technician;
use App\TechnicianSale;
use Validator;

class TechnicianSaleController extends Controller
{
    //
    public function index(){

        $now = Carbon::now();
        if($now->day < 15){
            if($now->month == 3 && $now->isLeapYear()){
                $start = Carbon::createFromDate($now->year,$now->subMonth()->month,29);
            }
            else if($now->month == 3 && !$now->isLeapYear()){
                $start = Carbon::createFromDate($now->year,$now->subMonth()->month,28);
            }
            else{
                $start = Carbon::createFromDate($now->year,$now->subMonth()->month,30);
            }
            $end = Carbon::createFromDate($now->year, $now->addMonth()->month,15);
        }
        else{
            $start = Carbon::createFromDate($now->year,$now->month, 15);
            if($now->month == 2 && $now->isLeapYear()){
                $end = Carbon::createFromDate($now->year, $now->month, 29);
            }
            else if($now->month == 2 && !$now->isLeapYear()){
                $end = Carbon::createFromDate($now->year, $now->month, 28);
            }
            else{
                $end = Carbon::createFromDate($now->year, $now->month, 30);
            }

        }

        $payDates = [];
        $paySchedule = [];
        while($start < $end){

            if($start->day == 15 && $start->month == 2 && $start->daysInMonth == 29){
                $start = $start->addDay(14);
            }
            else if($start->day == 15 && $start->month == 2 && $start->daysInMonth == 28){
                $start = $start->addDay(13);
            }
            else if($start->day == 15 && $start->month != 2){
                $start = $start->addDay(15);
            }
            else if($start->day == 30 && $start->daysInMonth == 31){
                $start = $start->addDay(16);
            }
            else if($start->day == 30 && $start->daysInMonth == 30){
                $start = $start->addDay(15);
            }
            else if($start->day == 28 && $start->month == 2){
                $start = $start->addDay(15);
            }
            else if($start->day == 29 && $start->month == 2){
                $start = $start->addDay(15);
            }
            array_push($payDates, $start->toDateString());
        }
        foreach($payDates as $payDate){
            $date = Carbon::createFromFormat('Y-m-d', $payDate);
            $dateTwo = clone $date;
            $endPeriod = $date->subDays(2);

            if($dateTwo->day == 15 && $dateTwo->month <> 3){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->subMonth()->month, 29);
            }
            elseif($dateTwo->day == 15 && $dateTwo->month == 3 && $dateTwo->isLeapYear()){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->subMonth()->month, 28);
            }
            elseif($dateTwo->day == 15 && $dateTwo->month == 3 && !$dateTwo->isLeapYear()){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->subMonth()->month, 27);
            }
            else if($dateTwo->day == 30 || $dateTwo->day == 28 || $dateTwo->day == 29){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->month, 14);
            }
            $paySchedule = ['payDate'=> $payDate, 'payPeriod'=> $beginPeriod->toDateString(). " - ". $endPeriod->toDateString()];
        }



        $technicians = Technician::orderBy('last_name', 'asc')->select('first_name','last_name')->get();

        return view('technicians.sales', ['technicians' => $technicians, 'paySchedule' => $paySchedule]);
    }


    public function createSale(Technician $technician){

        $payPeriod = ['2017-04-29','2017-05-13'];
        $technicianID = $technician->id;

        $sales = Technician::with(['dailySales' =>
            function($query) use ($payPeriod){

                $query->whereBetween('sale_date',$payPeriod);

            }])->where('id', '=', $technicianID)->get(['id','first_name', 'last_name']);

        /*foreach($sales as $sale){
            echo $sale;
        }*/
        return view('technicians.create-sales', ['technician' => $sales]);

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

        $sale->technician_id = $request->input('technicianID');
        $sale->sale_date = Carbon::createFromFormat('m/d/Y',$request->input('sale-date'))->toDateString();
        $sale->sales = $request->input('sale');
        $sale->additional_sales = $request->input('additional-sale');

        $sale->save();

        $request->session()->flash('confirm-sale', 'Sale has been added for ' . $name);
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
        $saleDate = Carbon::createFromFormat('Y-m-d H:i:s',$sale->sale_date)->format('m/d/Y');

        $sale->update();

        return response()->json(['success' => true, 'message' => 'Sale has been updated for ' . $saleDate,
            'sale' => $sale->sales, 'additionalSale' => $sale->additional_sales],200)
            ->header('Content-type', 'application/json');

    }

    public function searchByDate(Request $request){

        $technicianID =  $request->input('technicianID');
        $saleDate = $request->input('saleDate');

        $sale = TechnicianSale::where([['technician_id','=',$technicianID],['sale_date','=', $saleDate]])->get();


        return response()->json(['success' => true, 'message' => $sale],200)->header('Content-type', 'application/json');

    }
}
