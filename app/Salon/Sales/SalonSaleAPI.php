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
            $metrics['Technician Sales'] = number_format((float)$techSales,2);
            $metrics['Gift Certificate Redeemed'] = number_format(0 - $sales->gift_certificate_redeemed,2);

            foreach($sales->salonSaleDetails as $items){
                $metrics[$items->item] =$items->gross_sales;
            }

            /*$sum = 0;

            foreach($metrics as $item => $value){
                $sum += $value;
            }*/
            $metrics['Card Collected'] = $sales->cards_collected;
            $metrics['Cash Collected'] = $sales->cash_collected;
            $metrics['CC Fees'] = $sales->fees;
            $metrics['Refunded'] = $sales->refunded;
            $metrics['Square Gross Sales'] = number_format((float)$sales->gross_sales,2);
            $grossSaleDifference = $techSales - $sales->grossSales;
            $metrics['Gross Sales Difference'] = number_format($grossSaleDifference,2);

            $metrics['Square Net Sales'] = number_format($metrics['Square Gross Sales'] - $metrics['Refunded'],2);
            $metrics['Technician Net Sales'] = number_format($metrics['Technician Sales'] - $metrics['Refunded'],2);
            $metrics['Net Sales Difference'] = number_format($metrics['Technician Sales'] - $metrics['Refunded']-($metrics['Square Gross Sales'] - $metrics['Refunded']),2);

            $metrics['Square Total Collected'] = number_format($metrics['Square Gross Sales'] - $metrics['Refunded'] + $metrics['Gift Certificate'] +
                $sales->tips,2);

            $metrics['Technician Total Collected'] = number_format($metrics['Technician Sales']
                + $metrics['Gift Certificate'] + $metrics['Gift Certificate Redeemed'] + $metrics['Convenience Fee'] + $tipsOnCard,2);

            $metrics['Total Collected Difference'] = number_format($metrics['Technician Sales']
                + $metrics['Gift Certificate'] + $metrics['Gift Certificate Redeemed'] + $metrics['Convenience Fee'] + $tipsOnCard -($metrics['Square Gross Sales']
                    - $metrics['Refunded'] + $metrics['Gift Certificate'] + $sales->tips),2);

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