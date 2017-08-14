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
        }])->where('date',$date)->first(['id','date','gross_sales','tips','fees','gift_certificate_redeemed',
            'cards_collected','cash_collected','refunded']);

        $techSales = TechnicianSale::where('sale_date', $date)->sum('sales');

        $tipsOnCard = TechnicianSale::where('sale_date', $date)->sum('additional_sales');


        if($sales !== null){
            $metrics['Technician Sales'] = $techSales;
            $metrics['Gift Certificate Redeemed'] = 0 - $sales->gift_certificate_redeemed;

            foreach($sales->salonSaleDetails as $items){
                $metrics[$items->item] =$items->gross_sales;
            }

            $grossSaleDifference = $techSales - $sales->gross_sales;
            $squareNetSales = $sales->gross_sales - $sales->refunded;
            $netSaleDifference = $techSales -$sales->refunded - ($sales->gross_sales - $sales->refunded);
            $technicianNetSale = $techSales - $sales->refunded;
            $squareTotalCollected = $sales->gross_sales - $sales->refunded + (float)$metrics['Gift Certificate'] + $sales->tips;
            $technicianTotalCollected = $techSales + (float)$metrics['Gift Certificate'] + (float)$metrics['Gift Certificate Redeemed'] + (float)$metrics['Convenience Fee'] + $tipsOnCard;
            $totalCollectedDifference = $techSales + (float)$metrics['Gift Certificate'] + (float)$metrics['Gift Certificate Redeemed'] +
                (float)$metrics['Convenience Fee'] + $tipsOnCard - ($sales->gross_sales - $sales->refunded + $metrics['Gift Certificate'] + $sales->tips);



            $metrics['Card Collected'] = $sales->cards_collected;
            $metrics['Cash Collected'] = $sales->cash_collected;
            $metrics['CC Fees'] = $sales->fees;
            $metrics['Refunded'] = $sales->refunded;
            $metrics['Square Gross Sales'] = $sales->gross_sales;

            $metrics['Gross Sales Difference'] = $grossSaleDifference;

            $metrics['Square Net Sales'] = $squareNetSales;
            $metrics['Technician Net Sales'] = $technicianNetSale;
            $metrics['Net Sales Difference'] = $netSaleDifference;

            $metrics['Square Total Collected'] = $squareTotalCollected;

            $metrics['Technician Total Collected'] = $technicianTotalCollected;

            $metrics['Total Collected Difference'] = $totalCollectedDifference;

            $tips = ['Technician Tips' => $tipsOnCard,2,
                'Square Tips' => $sales->tips, 'Tips Difference' => $tipsOnCard-$sales->tips,];
            $result = ['success' => true, 'sales' => $metrics, 'tips' => $tips];
        }
        else{
            $result = ['success' => false, 'message' => 'no sale'];
        }

        return $result;
    }


}