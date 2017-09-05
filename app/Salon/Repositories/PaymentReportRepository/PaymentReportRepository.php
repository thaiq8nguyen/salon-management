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

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
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

        $technicianSales = $this->sales->getSales($technician, $payPeriod);
        $technicianWage =  $this->wage->getWage($technician, $payPeriod);
        $technicianPayment = $this->payments->getPayments($technician, $payPeriod);
        $totalBalance = $this->sales->getTotalBalance($technician, $payPeriod);
        $payPeriodBalance = $this->sales->getPayPeriodBalance($technician, $payPeriod);

        $data = ['technician' => $technician, 'sales'=>$technicianSales,
            'wage'=>$technicianWage,'payments'=>$technicianPayment,
            'payPeriod' => $payPeriod->pay_period_mdy, 'payDate' => $payPeriod->pay_date_mdy,
            'totalBalance' => $totalBalance, 'periodBalance' => $payPeriodBalance];

        $this->report = PDF::loadView('pdf.payment', $data )
            ->setPaper('letter','portrait')->setOptions(['dpi'=>96]);

        $filePath = "technician-payment/reports/".$technician->first_name."_".$technician->last_name."_payment_report_".$payPeriod->pay_date.".pdf";

        Storage::cloud()->put($filePath,$this->report->output());

        $url = Storage::cloud()->url($filePath);

        $technician->payPeriods()->attach($payPeriodId,['payment_report_url' => $url]);

        return $url;

    }

    public function store(){


    }

    public function show($technicianId, $payPeriodId)
    {
        $this->create($technicianId, $payPeriodId);

        return $this->report->save('payment.pdf');

    }

}