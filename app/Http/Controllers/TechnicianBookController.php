<?php

namespace App\Http\Controllers;

use App\Technician;
use App\TechnicianBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class TechnicianBookController extends Controller
{
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
        $openingBalance = (float)$request->input('opening-balance');

        $date = Carbon::now()->toDateString();
        $book = TechnicianBook::where([['technician_id','=',$technicianID],['reference','=','opening balance']])
            ->first(['date','balance']);

        if(count($book) == 0){
            $technician = new TechnicianBook;
            $technician->technician_id = $technicianID;
            $technician->reference = 'opening balance';
            $technician->balance = $openingBalance;
            $technician->date = $date;
            $technician->save();
        }
        else{
            return redirect('/technician-book/create')->with('error','The technician already has a book record');
        }
        return redirect('/technician-book/create')->with('message','You have created a book record for the technician');
    }
}
