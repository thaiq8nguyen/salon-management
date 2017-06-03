<?php

namespace Salon\Sales;

use App\SalonSale;
use Carbon\Carbon;
use Salon\Square\Square;


class SalonSaleAPI{

    protected $sale;

    public function __construct(SalonSale $salonSale)
    {
        $this->sale = $salonSale;
    }


    public function getDailySaleMetrics(){
        $date = Carbon::now()->toDateString();
        $dailySale = Square::getDailySaleMetrics();

        $this->sale->updateOrCreate(['date' => $date],$dailySale);

    }

}