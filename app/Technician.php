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

    function dailySales (){
        return $this->sales()
            ->select('technician_id','sale_date','sales','additional_sales')->orderBy('sale_date', 'ASC');
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
