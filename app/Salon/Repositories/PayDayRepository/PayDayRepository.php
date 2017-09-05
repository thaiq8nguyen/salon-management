<?php
namespace Salon\Repositories\PayDayRepository;
use App\Technician;
use App\PayPeriod;
use App\Salary;
use Carbon\Carbon;
use App\WagePayment;
use Salon\Repositories\PaymentReportRepository\PaymentReportRepositoryInterface;
use DB;


class PayDayRepository implements PayDayRepositoryInterface{

    protected $sales;
    protected $wages;
    protected $report;

    public function __construct(PaymentReportRepositoryInterface $report)
    {
        $this->report = $report;
    }

    /**
     * @param PayPeriod $payPeriod
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function sales(PayPeriod $payPeriod)
    {

        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];

        $this->sales = Technician::with([
            'dailySales' =>
                function($query) use ($payPeriodDates) {
                    $query->whereBetween('sale_date', $payPeriodDates);
                }])->get(['id','first_name','last_name']);

        return $this->sales;
    }

    /**
     * @param PayPeriod $payPeriod
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function wage(PayPeriod $payPeriod)
    {

        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];

        $this->wages = Technician::with([
            'totalSalesAndTips' =>
                function($query) use ($payPeriodDates) {
                    $query->whereBetween('sale_date', $payPeriodDates);
                }])->get(['id']);

        return $this->wages;

    }

    /**
     * Return pre-make payment suggestions based on the salaries table
     * @param PayPeriod $payPeriod
     * @return array
     */
    public function getPaymentSuggestions(PayPeriod $payPeriod)
    {
        $this->wage($payPeriod);

        $suggestPayments = [];

        foreach($this->wages as $wage ){

            if(count($wage->totalSalesAndTips) !== 0){

                $salary = Salary::where('technician_id','=',$wage->id)->get();

                $defaultPaymentAmount = $salary[0]->default_payment_amount;
                $defaultPaymentMethod =  $salary[0]->default_payment_method;
                $checkRatio = $salary[0]->check_ratio;
                $paymentScheme = $salary[0]->payment_scheme;

                $totalWage = $wage->totalSalesAndTips[0]->total;

                if($paymentScheme == 'normal'){

                    array_push($suggestPayments,['amount' => $totalWage,

                        'reference' => '', 'method'=>$defaultPaymentMethod]);
                }
                else if($paymentScheme == 'fixed'){

                    if($totalWage > $defaultPaymentAmount){

                        $firstAmount = rand(($defaultPaymentAmount - 10) * 10, ($defaultPaymentAmount + 10)*10)/10;
                        $secondAmount = $defaultPaymentAmount - $firstAmount;

                        array_push($suggestPayments,['amount' => number_format($firstAmount,2),

                            'reference' => 'check', 'method' => $defaultPaymentMethod],

                            ['amount' => number_format($secondAmount,2),

                                'reference' => '', 'method' => 'cash' ]);
                    }
                    else{

                        array_push($suggestPayments,['amount' =>$totalWage,

                            'reference' => 'check', 'method'=>$defaultPaymentMethod]);
                    }
                }
                else if($paymentScheme == 'ratio'){

                    array_push($suggestPayments,['amount' => number_format($totalWage * $checkRatio,2),

                        'reference' => 'cash', 'method' => $defaultPaymentMethod],

                        ['amount' => number_format($totalWage - $totalWage * $checkRatio,2),

                            'reference' => '', 'method' => 'check' ]);
                }

            }

        }
        return $suggestPayments;
    }

    /**
     * Return technicians sales data, compute wages, and payment report (if they were paid) to pay view
     * @param PayPeriod $payPeriod
     * @return array
     */
    public function payday(PayPeriod $payPeriod)
    {
        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];
        $payPeriodId = $payPeriod->id;

        $technicians = Technician::with([
            'dailySales' =>
                function($query) use ($payPeriodDates) {
                    $query->whereBetween('sale_date', $payPeriodDates);
                },

            'totalSalesAndTips' =>
                function($query) use($payPeriodDates){
                    $query->whereBetween('sale_date', $payPeriodDates);
                },
            'paymentReport' =>
                function($query) use($payPeriodId){
                    $query->wherePivot('pay_period_id','=',$payPeriodId)->get(['id']);
                },
            'payments' =>
                function($query) use($payPeriodId){
                    $query->where('pay_period_id','=' , $payPeriodId);
                },
            'salary'
        ])->orderBy('last_name')->get(['id','first_name','last_name']);

        $results = [];
        $range = 1;

        foreach($technicians as $technician){

            $suggestPayments = [];
            $result['payment_report'] = $technician->paymentReport;
            $result['payments'] = $technician->payments;
            $result['daily_sales'] = $technician->dailySales;
            $result['id'] = $technician->id;
            $result['salary_setup'] = $technician->salary;
            $result['total_sales_and_tips'] = $technician->totalSalesAndTips;
            $result['full_name'] = $technician->fullName;
            $result['first_name'] = $technician->first_name;

            if(count($technician->totalSalesAndTips) !== 0){

                $defaultPaymentAmount = $technician->salary->default_payment_amount;
                $defaultPaymentMethod =  $technician->salary->default_payment_method;
                $checkRatio = $technician->salary->check_ratio;
                $paymentScheme = $technician->salary->payment_scheme;

                $totalWage = $technician->totalSalesAndTips[0]->total;
                if($totalWage > 100){
                    $range = 10;
                }

                if($paymentScheme == 'normal'){

                    array_push($suggestPayments,['amount' => $totalWage,

                        'reference' => '', 'method'=>$defaultPaymentMethod]);
                }
                else if($paymentScheme == 'fixed'){

                    if($totalWage > $defaultPaymentAmount){

                        $firstAmount = rand(($defaultPaymentAmount - $range) * 10, ($defaultPaymentAmount + $range)*10)/10;
                        $secondAmount = $totalWage - $firstAmount;

                        array_push($suggestPayments,['amount' => number_format($firstAmount,2),

                            'reference' => '', 'method' => 'check'],

                            ['amount' => number_format($secondAmount,2),

                                'reference' => '', 'method' => 'cash' ]);
                    }
                    else{

                        array_push($suggestPayments,['amount' =>$totalWage,

                            'reference' => 'check', 'method'=>$defaultPaymentMethod]);
                    }
                }
                else if($paymentScheme == 'ratio'){

                    array_push($suggestPayments,['amount' => number_format($totalWage * $checkRatio,2),

                        'reference' => '', 'method' => 'check'],

                        ['amount' => number_format($totalWage - $totalWage * $checkRatio,2),

                            'reference' => '', 'method' => 'cash' ]);
                }

            }

            $result['suggested_payments'] = $suggestPayments;
            array_push($results, $result);
        }

        return $results;
    }

    /**
     * Store payments to the technicians on their id, pay period id
     * Also compute the total amount paid and sales amount in the technician book
     * @param $technicianId
     * @param $payPeriodId
     * @param $payments
     * @return array
     */
    public function payTechnician($technicianId, $payPeriodId, $payments)
    {
        $technician = Technician::find($technicianId);

        $payPeriod = PayPeriod::find($payPeriodId);

        $payPeriodDates = [$payPeriod->begin_date, $payPeriod->end_date];


        $wagePayments = [];
        $totalAmount = 0.0;
        $date = Carbon::now()->toDateString();
        foreach($payments as $payment){

            $totalAmount += $payment['amount'];
            $payment['pay_period_id'] = $payPeriodId;
            $payment['pay_date'] = $date;
            $payment['expense_account'] = 'wages';
            $wagePayments[] = new WagePayment($payment);
        }

        $technician->payments()->saveMany($wagePayments);

        $sales = Technician::with(['totalSalesAndTips' =>
            function ($query) use ($payPeriodDates) {
                $query->whereBetween('sale_date',$payPeriodDates);
            }])->where('id', '=', $technicianId)->first(['id']);

        $totalSale = $sales->totalSalesAndTips[0]->total;

        DB::table('technician_books')->insert(
            ['technician_id' => $technicianId, 'pay_period_id' => $payPeriodId, 'date' => $date,
                'description' => 'sales', 'sales' => $totalSale,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()]);

        DB::table('technician_books')->insert(
            ['technician_id' => $technicianId, 'pay_period_id' => $payPeriodId, 'date' => $date,
                'description' => 'wages', 'payments' => $totalAmount,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()]
        );

        $this->report->create($technicianId,$payPeriodId);

        $result = ['success'=>true, 'message'=> $technician->full_name . ' \'s is paid!'];

        return $result;
    }
}