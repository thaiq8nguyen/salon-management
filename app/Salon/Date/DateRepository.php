<?php namespace Salon\Date;

use App\Date;
use App\TechnicianWeeklyScheduleTemplate;
use Carbon\Carbon;
use App\Technician;

class DateRepository implements DateInterface {

    public function create()
    {
        /*$now = Carbon::now();
        $date = clone $now;

        while($date->quarter == $now->quarter){

            Date::create(['full_date' => $date->toDateString(), 'day' => $date->format('l'), 'month_number' => $date->month,
                'month_name' => $date->format('F'), 'day_number_of_week' => $date->dayOfWeek + 1, 'day_number_of_month' => $date->day,
                'number_of_days_in_month' => $date->daysInMonth, 'number_of_days_in_year' => 365 + $date->format('L')]);

            $date->addDay(1);
        }*/

    }

    public function timeOff()
    {
        $technicians = Technician::with('scheduleTemplate')->get(['id','nickname']);

        $result = [];
        foreach($technicians as $technician){

            array_push($result, $technician['scheduleTemplate']);

        }

        /*foreach($technicians as $technician){
            $dates =  Date::all();
            foreach($dates as $date){
                if($technician->scheduleTemplate->day == $date->day){
                    $technician->scheduleTemplate()->attach($date->id,['is_working' => $technician->scheduleTemplate->worked]);
                }
            }

        }*/


        return $result;

    }

}
