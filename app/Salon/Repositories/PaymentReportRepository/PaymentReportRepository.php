<?php
namespace Salon\Repositories\PaymentReportRepository;

use App\Technician;
use App\PayPeriod;
use Salon\Repositories\TechnicianSaleRepository\TechnicianSaleRepositoryInterface;
use Salon\Repositories\TechnicianWageRepository\TechnicianWageRepositoryInterface;
use Salon\Repositories\TechnicianPaymentRepository\TechnicianPaymentRepositoryInterface;
use Barryvdh\DomPDF\Facade as PDF;
use Storage;
use Carbon\Carbon;


class PaymentReportRepository implements PaymentReportRepositoryInterface{

    protected $sales;
    protected $wage;
    protected $payments;
    protected $report;

    public function __construct(TechnicianSaleRepositoryInterface $sales,
                                TechnicianWageRepositoryInterface $wage,
                                TechnicianPaymentRepositoryInterface $payments)
    {
        $this->sales = $sales;
        $this->wage = $wage;
        $this->payments = $payments;

    }

    public function all()
    {
        $sixMonthAgo = Carbon::now()->subMonth(6)->toDateTimeString();

        $this->report = Technician::with(['paymentReport' =>
        function($query) use($sixMonthAgo){
            $query->wherePivot('created_at','>',$sixMonthAgo);
        }])->orderBy('last_name','asc')->get(['id', 'first_name', 'last_name']);

        return $this->report;

    }

    public function update($technicianId, $payPeriodId)
    {
        $technician = Technician::find($technicianId);
        $payPeriod = PayPeriod::find($payPeriodId);
        $previousPayPeriod = PayPeriod::orderBy('pay_date','desc')->take(1)->skip(1)->first();

        $technicianSales = $this->sales->getSales($technician, $payPeriod);
        $technicianWage =  $this->wage->getWage($technician, $payPeriod);
        $technicianPayment = $this->payments->getPaymentsByPayPeriod($technicianId, $payPeriodId);
        $totalBalance = $this->sales->getTotalBalance($technicianId, $payPeriodId);
        $previousTotalBalance = $this->sales->getTotalBalance($technicianId,$previousPayPeriod->id);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technicianId, $payPeriodId);

        $data = ['technician' => $technician, 'sales'=>$technicianSales,
            'wage'=>$technicianWage,'payments'=>$technicianPayment,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy,
            'totalBalance' => $totalBalance, 'periodBalance' => $payPeriodBalance, 'previousTotalBalance' => $previousTotalBalance];

        $this->report = PDF::loadView('pdf.payment', $data )
            ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);

        $file = "technician-payment/reports/".$technician->first_name."_".$technician->last_name."_payment_report_".$payPeriod->pay_date.".pdf";

        $this->delete($file);

        $url = $this->store($file);

        $technician->payPeriods()->updateExistingPivot($payPeriodId, ['payment_report_url' => $url]);

        return $url;


    }

    public function delete($file)
    {

        Storage::cloud()->delete($file);

    }

    /**
     * Create a pdf report
     * @param $technicianId
     * @param $payPeriodId
     * @return mixed
     */
    public function create($technicianId, $payPeriodId)
    {
        $technician = Technician::find($technicianId);
        $payPeriod = PayPeriod::find($payPeriodId);
        $previousPayPeriod = PayPeriod::orderBy('pay_date','desc')->take(1)->skip(1)->first();

        $technicianSales = $this->sales->getSales($technician, $payPeriod);
        $technicianWage =  $this->wage->getWage($technician, $payPeriod);
        $technicianPayment = $this->payments->getPaymentsByPayPeriod($technicianId, $payPeriodId);
        $totalBalance = $this->sales->getTotalBalance($technicianId, $payPeriodId);
        $previousBalance = $this->sales->getPayPeriodBalance($technicianId,$previousPayPeriod->id);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technicianId, $payPeriodId);

        $data = ['technician' => $technician, 'sales'=>$technicianSales,
            'wage'=>$technicianWage,'payments'=>$technicianPayment,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy,
            'totalBalance' => $totalBalance, 'periodBalance' => $payPeriodBalance, 'previousBalance' => $previousBalance];

        $this->report = PDF::loadView('pdf.payment', $data )
            ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);

        $file = "technician-payment/reports/".$technician->first_name."_".$technician->last_name."_payment_report_".$payPeriod->pay_date.".pdf";

        $url = $this->store($file);

        $technician->payPeriods()->attach($payPeriodId,['payment_report_url' => $url]);

        return $url;


    }


    public function store($file){

        Storage::cloud()->put($file,$this->report->output());

        $url = Storage::cloud()->url($file);

        return $url;

    }

    public function url($technicianId, $payPeriodId)
    {
        $technician = Technician::find($technicianId);

        return $technician->paymentReport()->wherePivot('pay_period_id','=',$payPeriodId)->first();


    }

    public function listReports($technicianId, $months)
    {
        $date = Carbon::now()->subMonth($months)->toDateTimeString();

        $this->report = Technician::with(['paymentReport' =>
            function($query) use($date){
                $query->wherePivot('created_at','>',$date);
            }])
            ->orderBy('last_name','asc')->where('id','=',$technicianId)
            ->get(['id', 'first_name', 'last_name']);

        return $this->report;

    }

    public function preview($technicianId, $payPeriodId)
    {
        $technician = Technician::find($technicianId);
        $payPeriod = PayPeriod::find($payPeriodId);
        $previousPayPeriod = PayPeriod::orderBy('pay_date','desc')->take(1)->skip(1)->first();

        $technicianSales = $this->sales->getSales($technician, $payPeriod);
        $technicianWage =  $this->wage->getWage($technician, $payPeriod);
        $technicianPayment = $this->payments->getPaymentsByPayPeriod($technicianId, $payPeriodId);
        $totalBalance = $this->sales->getTotalBalance($technicianId, $payPeriodId);
        $previousBalance = $this->sales->getPayPeriodBalance($technicianId,$previousPayPeriod->id);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technicianId, $payPeriodId);

        $data = ['technician' => $technician, 'sales'=>$technicianSales,
            'wage'=>$technicianWage,'payments' => $technicianPayment,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy,
            'totalBalance' => $totalBalance, 'periodBalance' => $payPeriodBalance, 'previousBalance' => $previousBalance];

        $this->report = PDF::loadView('pdf.payment', $data )
            ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);

        //print_r($data);

        return $this->report->stream('payment-report.pdf');
    }

}