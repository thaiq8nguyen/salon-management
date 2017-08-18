<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Salon\GiftCertificates\Gift;
use Carbon\Carbon;



class GiftCertificateController extends Controller
{
    public function index(){

        return(Gift::getDailyGiftsSold());



    }
}
