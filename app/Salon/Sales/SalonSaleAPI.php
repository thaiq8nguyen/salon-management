<?php

namespace Salon\Sales;

use App\SalonSale;
use App\SalonSaleDetails;
use Carbon\Carbon;
use Salon\Square\Square;


class SalonSaleAPI{

    protected $sale;

    public function __construct(SalonSale $salonSale)
    {
        $this->sale = $salonSale;
    }


    public function getSquareDailySaleMetrics(){
        $date = Carbon::now()->toDateString();

        $dailySale = Square::getDailySaleMetrics();

        $sale = $this->sale->updateOrCreate(['date' => $date],$dailySale['metrics']);

        SalonSaleDetails::where('salon_sale_id',$sale->id)->delete();

        $items = [];

        foreach($dailySale['items'] as $item){
            $items[] = new SalonSaleDetails($item);
        }

        $sale->salonSaleDetails()->saveMany($items);
    }


}