<?php

namespace App;
use App\PayPeriod;
use Illuminate\Database\Eloquent\Model;
/*
 * @property $first_name
 */
class Technician extends Model
{

    public function user(){

        return $this->hasOne(User::class);

    }
    public function sales(){

        return $this->hasMany(TechnicianSale::class);

    }
    public function payPeriods(){

        return $this->belongsToMany(PayPeriod::class,'technician_pay_period')
            ->withPivot('payment_report_url')
            ->withTimestamps();
    }

    public function paymentReport(){

        return $this->payPeriods()->select('payment_report_url');

    }

    public function payments(){

        return $this->hasMany(WagePayment::class);

    }

    public function countSales(){

        return $this->sales()
            ->selectRaw('technician_id, count(*) as numberOfSale')
            ->groupBy('technician_id');

    }



    public function countPayments(){
        return $this->payments()
            ->selectRaw('technician_id, count(pay_period_id) as numberOfPayment')
            ->groupBy('technician_id');
    }

    public function dailySales (){
        return $this->sales()
            ->select('technician_id','id','sale_date','sales','additional_sales')->orderBy('sale_date', 'ASC');
    }

    public function totalSales(){

        return $this->sales()
           ->selectRaw('technician_id, sum(sales) as subTotal, ROUND(sum(sales) * ' . $this->salary->commission_rate .',2) as earnedTotal')
           ->groupBy('technician_id');
    }
    public function totalTips(){
        return $this->sales()
            ->selectRaw('technician_id, sum(additional_sales) as subTotalTip, ROUND(sum(additional_sales) * ' . $this->salary->tip_rate .',2) as earnedTip')
            ->groupBy('technician_id');

    }


    public function totalSalesAndTips(){

        return $this->sales()
            ->selectRaw('technician_sales.technician_id, sum(sales) as subTotal, ROUND(sum(sales) * salaries.commission_rate,2) as earnedTotal,
                        sum(additional_sales) as subTotalTip, ROUND(sum(additional_sales) * salaries.tip_rate,2) as earnedTip,
                        ROUND(sum(sales) * salaries.commission_rate - sum(additional_sales) * salaries.tip_rate,2) as total')
            ->join('salaries','technician_sales.technician_id','=','salaries.technician_id')
            ->groupBy('technician_id');
    }




    public function salary(){
        return $this->hasOne(Salary::class)->select(['technician_id','commission_rate',
            'tip_rate','check_ratio','number_of_payment','payment_scheme','default_payment_amount','default_payment_method']);
    }

    public function getFullNameAttribute(){
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function getRouteKeyName(){
        return 'first_name';
    }


}
