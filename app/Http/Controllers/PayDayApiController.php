<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayPeriod;
use App\Technician;
use App\WagePayment;
use Carbon\Carbon;
use DB;
use Salon\Repositories\PayDayRepository\PayDayRepositoryInterface;

class PayDayApiController extends Controller
{
    protected $technicians;
    public function __construct(PayDayRepositoryInterface $technician)
    {
        $this->technician = $technician;
    }

    public function payday(Request $request){


        $payPeriod = PayPeriod::find($request->id);

        $payDay = $this->technician->payday($payPeriod);

        return response()->json($payDay);

    }

    public function payTechnician(Request $request){

        $technicianId = $request->payingTechnicianId;

        $periodId = $request->periodId;

        $payments = $request->payments;

        $pay = $this->technician->payTechnician($technicianId, $periodId, $payments);

        return response()->json($pay);


    }

    public function searchWageByPeriod(PayPeriod $payPeriod, Technician $technician){

        $technicianId = $technician->id;

        $technician = Technician::with(['totalSalesAndTips' =>
            function($query) use ($payPeriod){

                $query->whereBetween('sale_date',[$payPeriod->begin_date, $payPeriod->end_date]);

            }])->where('id', '=', $technicianId)->first();


        return response()->json($technician->totalSalesAndTips,
            200);

    }

    public function searchPaymentByPeriod(PayPeriod $payPeriod, Technician $technician){
        $technicianId = $technician->id;
        $payPeriodId = $payPeriod->id;

        $payments = WagePayment::where('pay_period_id','=',$payPeriodId)->where('technician_id','=',$technicianId)->get();

        return response()->json($payments,200);
    }
}


