<?php

namespace App\Http\Controllers;

use App\Technician;
use Illuminate\Http\Request;
use Salon\Repositories\TechnicianRepository\TechnicianRepositoryInterface;

class TechnicianDetailApiController extends Controller
{

    protected $technician;
    public function __construct(TechnicianRepositoryInterface $technician)
    {

        $this->technician = $technician;

    }
    public function getByCategory(Request $request){

        return response()->json($this->technician->getTechnicianByCategoryLimited($request->input('category')),200);

    }
    public function getSalarySetup(Request $request){

        $technicianId = $request->input('id');

        $salarySetup = Technician::find($technicianId)->salary;

        return response()->json($salarySetup,200)->header('Content-type','application/json');
    }
}
