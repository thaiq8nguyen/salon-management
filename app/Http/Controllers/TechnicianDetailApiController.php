<?php

namespace App\Http\Controllers;

use App\Technician;
use Illuminate\Http\Request;

class TechnicianDetailApiController extends Controller
{
    public function getSalarySetup(Request $request){

        $technicianId = $request->input('id');

        $salarySetup = Technician::find($technicianId)->salary;

        return response()->json($salarySetup,200)->header('Content-type','application/json');
    }
}
