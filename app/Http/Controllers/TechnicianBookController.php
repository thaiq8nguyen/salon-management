<?php

namespace App\Http\Controllers;

use App\PayPeriod;
use App\Technician;
use App\TechnicianBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use DB;

class TechnicianBookController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','checkPayPeriod']);
    }
    public function index(){
        return view('technicians.book');
    }

    public function create(){

        $technicians = Technician::orderBy('last_name')->get(['id','first_name','last_name']);

        return view('technicians.create-book',['technicians'=> $technicians]);
    }

    public function store(Request $request){

        $this->validate($request,[
            'technician-id' => 'required',
            'opening-balance' => 'required',
        ]);

        $technicianID = $request->input('technician-id');
        $openingBalance = $request->input('opening-balance');

        $date = Carbon::now()->toDateTimeString();
        $countBook = TechnicianBook::where([['technician_id','=',$technicianID],['reference','=','opening balance']])
            ->first(['date','payments']);

        if(count($countBook) == 0){
            $technician = new TechnicianBook;
            $technician->technician_id = $technicianID;
            $technician->reference = 'opening balance';
            $technician->payments = $openingBalance;
            $technician->date = $date;
            $technician->save();
        }
        else{
            return redirect('/technician-book/create')->with('error','The technician already has a book record');
        }
        return redirect('/technician-book/create')->with('message','You have created a book record for the technician');
    }
    public function insertWages(Request $request){

        $payPeriod = session()->get('payPeriod');
        $technicianID = session()->get('payingTechnicianID');
        $payPeriodID = $payPeriod->id;
        $pay = session()->pull('wageAmount');
        $date = Carbon::now()->toDateTimeString();
        $description = 'wages';
        $technician = Technician::find($technicianID);

        $this->insertSales();

        DB::table('technician_books')->insert(
            ['technician_id' => $technicianID, 'pay_period_id' => $payPeriodID, 'date' => $date,
                'description' => $description, 'payments' => $pay,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()]
        );

        return redirect()->route('payday')->with('success-pay',$technician->first_name . ' \'s is paid ');

    }

    public function insertSales()
    {

        $date = Carbon::now()->toDateTimeString();
        $description = 'sales';
        $technicianID = session()->get('payingTechnicianID');

        $payPeriod =  session()->get('payPeriod');

        $payPeriodID = $payPeriod->id;

        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];

        $technician = Technician::with(['totalSalesAndTips' =>
            function ($query) use ($payPeriodDates) {
                $query->whereBetween('sale_date',$payPeriodDates);
            }])->where('id', '=', $technicianID)->first(['id', 'first_name', 'last_name']);

        $sales = $technician->totalSalesAndTips[0]->total;

        DB::table('technician_books')->insert(
        ['technician_id' => $technicianID, 'pay_period_id' => $payPeriodID, 'date' => $date,
            'description' => $description, 'sales' => $sales,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()]);

    }
}
