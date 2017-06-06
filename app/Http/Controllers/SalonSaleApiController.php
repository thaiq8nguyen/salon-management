<?php

namespace App\Http\Controllers;
use App\SalonSale;
use App\TechnicianSale;
use App\SalonSaleDetails;
use Illuminate\Http\Request;



class SalonSaleApiController extends Controller
{

    public function createSale(Request $request){
        $rules =[
            'date' => 'required',
            'grossSales' => 'required|numeric',
            'giftCardSolds' => 'nullable|numeric',
            'giftCardRedeemeds' => 'nullable|numeric',
            'tips' => 'nullable|numeric',
            'convenienceFees' => 'nullable|numeric'
        ];

        $this->validate($request,$rules);


        $date = $request->input('date');
        $grossSales = $request->input('grossSales');
        $giftCardSolds =  $request->input('giftCardSolds');
        $giftCardRedeemeds = $request->input('giftCardRedeemeds');
        $tips = $request->input('tips');
        $convenienceFees = $request->input('convenienceFees');

        $countSale = SalonSale::where('date',$date)->count();

        if($countSale > 0){
            return response()->json(['success' => false, 'message' => 'SalonSaleAPI is already existed'],200)
                ->header('Content-type', 'application/json');
        }


        $sale = SalonSale::create(['date' => $date, 'gross_sales' => $grossSales,
            'giftcard_sold' => $giftCardSolds, 'giftcard_redeemed' => $giftCardRedeemeds, 'tips' => $tips]);

        $salonSaleDetail = new SalonSaleDetails(['item' => 'convenience fee', 'gross_sales' => $convenienceFees,
            'item_sold' => 1]);

        $sale->salonSaleDetails()->save($salonSaleDetail);



        return response()->json(['success' => true, 'message' => 'The sales have been added'],200)->
        header('Content-type', 'application/json');
    }
    public function getSquareSale(Request $request){

        $date =  $request->input('date');



        $sales = SalonSale::with(['salonSaleDetails' => function($query){
            $query->orderBy('item','asc')->select('salon_sale_id','item','gross_sales');
        }])->where('date',$date)->first(['id','date','gross_sales','tips','fees']);

        if($sales !== null){


            $result = ['success' => true, 'metrics' => $sales];
        }
        else{
            $result = ['success' => false, 'message' => 'No Sale'];
        }

        return response()->json($result,200);

    }

    public function getTechSale(Request $request){

        $date =  $request->input('date');


        $grossSales = TechnicianSale::where('sale_date', $date)->sum('sales');
        $tipsOnCard = TechnicianSale::where('sale_date', $date)->sum('additional_sales');


        $sales = ['grossSales' => number_format($grossSales,2), 'tipsOnCard' => number_format($tipsOnCard,2)];


        return response()->json($sales,200);
    }
}

