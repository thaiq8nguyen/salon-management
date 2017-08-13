<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //


}
