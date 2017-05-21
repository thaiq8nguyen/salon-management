<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class PayPeriod extends Model
{
    protected $fillable = ['begin_date','end_date','pay_date'];

    public function wagePayments(){
        $this->hasMany(WagePayment::class);
    }
    public function getBeginDateMDYAttribute(){
        return(Carbon::createFromFormat('Y-m-d', $this->begin_date )->format('m/d/Y'));
    }

    public function getEndDateMDYAttribute(){
        return(Carbon::createFromFormat('Y-m-d', $this->end_date)->format('m/d/Y'));
    }

    public function getPayDateMDYAttribute(){
        return(Carbon::createFromFormat('Y-m-d', $this->pay_date)->format('m/d/Y'));
    }

    public function getPayPeriodMDYAttribute(){
        return $this->begin_date_mdy . ' - ' . $this->end_date_mdy;
    }

    public static function create(){
        $now = Carbon::now();
        if($now->day < 15){
            if($now->month == 3 && $now->isLeapYear()){
                $start = Carbon::createFromDate($now->year,$now->subMonth()->month,29);
            }
            else if($now->month == 3 && !$now->isLeapYear()){
                $start = Carbon::createFromDate($now->year,$now->subMonth()->month,28);
            }
            else{
                $start = Carbon::createFromDate($now->year,$now->subMonth()->month,30);
            }
            $end = Carbon::createFromDate($now->year, $now->addMonth()->month,15);
        }
        else{
            $start = Carbon::createFromDate($now->year,$now->month, 15);
            if($now->month == 2 && $now->isLeapYear()){
                $end = Carbon::createFromDate($now->year, $now->month, 29);
            }
            else if($now->month == 2 && !$now->isLeapYear()){
                $end = Carbon::createFromDate($now->year, $now->month, 28);
            }
            else{
                $end = Carbon::createFromDate($now->year, $now->month, 30);
            }

        }
        $payDates = [];
        $payPeriod= [];
        while($start < $end){

            if($start->day == 15 && $start->month == 2 && $start->daysInMonth == 29){
                $start = $start->addDay(14);
            }
            else if($start->day == 15 && $start->month == 2 && $start->daysInMonth == 28){
                $start = $start->addDay(13);
            }
            else if($start->day == 15 && $start->month != 2){
                $start = $start->addDay(15);
            }
            else if($start->day == 30 && $start->daysInMonth == 31){
                $start = $start->addDay(16);
            }
            else if($start->day == 30 && $start->daysInMonth == 30){
                $start = $start->addDay(15);
            }
            else if($start->day == 28 && $start->month == 2){
                $start = $start->addDay(15);
            }
            else if($start->day == 29 && $start->month == 2){
                $start = $start->addDay(15);
            }
            array_push($payDates, $start->toDateString());
        }
        foreach($payDates as $payDate){
            $date = Carbon::createFromFormat('Y-m-d', $payDate);
            $dateTwo = clone $date;
            $endPeriod = $date->subDays(2);

            if($dateTwo->day == 15 && $dateTwo->month <> 3){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->subMonth()->month, 29);
            }
            elseif($dateTwo->day == 15 && $dateTwo->month == 3 && $dateTwo->isLeapYear()){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->subMonth()->month, 28);
            }
            elseif($dateTwo->day == 15 && $dateTwo->month == 3 && !$dateTwo->isLeapYear()){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->subMonth()->month, 27);
            }
            else if($dateTwo->day == 30 || $dateTwo->day == 28 || $dateTwo->day == 29){
                $beginPeriod = Carbon::createFromDate($dateTwo->year, $dateTwo->month, 14);
            }
            $payPeriod = ['begin_date' => $beginPeriod->toDateString(), "end_date" => $endPeriod->toDateString(), 'pay_date'=> $payDate,];
        }
        return $payPeriod;
    }


}
