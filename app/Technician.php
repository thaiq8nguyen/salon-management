<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/*
 * @property $first_name
 */
class Technician extends Model
{

    //
    public function sales(){

        return $this->hasMany(TechnicianSale::class);

    }

    public function countSales(){
        return $this->sales()
            ->selectRaw('technician_id, count(*) as numberOfSale')
            ->groupBy('technician_id');
    }
    public function payments(){
        return $this->hasMany(WagePayment::class);
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
            ->selectRaw('technician_id, sum(sales) as subTotal, ROUND(sum(sales) * ' . $this->salary->commission_rate .',2) as earnedTotal,
                        sum(additional_sales) as subTotalTip, ROUND(sum(additional_sales) * ' . $this->salary->tip_rate .',2) as earnedTip,
                        ROUND(sum(sales) * ' . $this->salary->commission_rate .' - sum(additional_sales) * ' . $this->salary->tip_rate .') as total')
            ->groupBy('technician_id');
    }

    public function salary(){
        return $this->hasOne(Salary::class);
    }

    public function getFullNameAttribute(){
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function getRouteKeyName(){
        return 'first_name';
    }


}
