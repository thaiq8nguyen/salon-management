<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Salon\Date\DateInterface;

class DateController extends Controller
{
    protected $date;
    public function __construct(DateInterface $date)
    {
        $this->date = $date;

    }

    public function timeOff(){
       echo( $this->date->timeOff());
    }
}
