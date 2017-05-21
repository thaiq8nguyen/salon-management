<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicianBookController extends Controller
{
    public function getBalanceAmountAttribute(){
        return '$ ' . $this->balance;
    }
}
