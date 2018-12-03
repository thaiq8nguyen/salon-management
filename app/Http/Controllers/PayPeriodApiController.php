<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PayPeriod;
use App\Services\PayPeriodService\PayPeriodReporter as Reporter;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface as WageReport;


class PayPeriodApiController extends Controller
{
    protected $reporter;
    protected $report;

    public function __construct(Reporter $reporter, WageReport $report)
    {
        $this->reporter = $reporter;
        $this->report = $report;

    }


    /**
     * Return the 5 latest pay period dates and their pay date
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function listing(){

        $date = Carbon::now()->toDateString();

        //Get the current pay period based on today's date
        $payPeriod = PayPeriod::where([['begin_date','<=',$date],['end_date','>=', $date]])->first();

        //If no pay period found then it must be that it is not in db yet
        if(!$payPeriod){
            return response()->json('New period is not in the database',422)->header('Content-type','application/json');
        }

        //Get the 3 latest pay day order by pay date in descending order.  Then reverse the collection to place the most recent pay period at the bottom.
        $periods = PayPeriod::where('pay_date','<=', $payPeriod->pay_date)->limit(5)->orderBy('pay_date','desc')
            ->get(['id','begin_date','end_date','pay_date'])->reverse();



        $list = [];
        //Format the collection
        foreach($periods as $period){
            $list[] = ['id' => $period->id, 'periods' => $period->begin_date_mdy . ' - ' . $period->end_date_mdy, 'payDate' => $period->pay_date_mdy];
        }
        return response()->json($list,200);
    }

    public function report(Request $request)
    {

        return response()->json($this->reporter->getReport($request->technicianId, $request->payPeriodId),200);

    }

    public function update(Request $request){

        return response()->json($this->report->update($request->technicianId, $request->payPeriodId),200);

    }
}
