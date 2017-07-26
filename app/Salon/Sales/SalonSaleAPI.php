<?php

namespace Salon\Sales;

use App\SalonSale;
use App\SalonSaleDetails;
use Carbon\Carbon;
use Salon\Square\Square;
use App\TechnicianSale;


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

    public function redeemGift($date, $amount){
        $sale = $this->sale->where('date',$date)->first();

        if($sale == null){

            return ['succcess' => false, 'message' => 'Cannot add the redeem amount without a sale metric'];
        }

        $sale->gift_certificate_redeemed = $amount;

        $sale->save();

        return ['success' => true, 'message' => 'Redeeming amount has been added or updated' ];

    }

    public function getDailySales($date){
        $metrics = [];
        $sales = SalonSale::with(['salonSaleDetails' => function($query){
            $query->orderBy('item','desc')->select('salon_sale_id','item','gross_sales');
        }])->where('date',$date)->first(['id','date','gross_sales','tips','fees','gift_certificate_redeemed']);

        $techSales = TechnicianSale::where('sale_date', $date)->sum('sales');

        $tipsOnCard = TechnicianSale::where('sale_date', $date)->sum('additional_sales');


        if($sales !== null){
            $metrics['Technician Sales'] = number_format($techSales,2);
            $metrics['Gift Certificate Redeemed'] = number_format(0 - $sales->gift_certificate_redeemed,2);

            foreach($sales->salonSaleDetails as $items){
                $metrics[$items->item] =$items->gross_sales;
            }

            $sum = 0;

            foreach($metrics as $item => $value){
                $sum += $value;
            }

            $metrics['Technician Gross Sales'] = number_format($sum,2);
            $metrics['Square Gross Sales'] = $sales->gross_sales;
            $metrics['Gross Sales Difference'] = number_format($metrics['Technician Gross Sales'] - $metrics['Square Gross Sales'],2);


            $tips = ['Technician Tips' => number_format($tipsOnCard,2),
                'Square Tips' => number_format($sales->tips,2), 'Tips Difference' => number_format($tipsOnCard-$sales->tips,2)];
            $result = ['success' => true, 'sales' => $metrics, 'tips' => $tips];
        }
        else{
            $result = ['success' => false, 'message' => 'no sale'];
        }

        return $result;
    }


}