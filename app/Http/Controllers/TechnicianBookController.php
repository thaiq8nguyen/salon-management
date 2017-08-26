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
        $this->middleware('admin');
    }
    public function index(){
        return view('technicians.book');
    }


}
