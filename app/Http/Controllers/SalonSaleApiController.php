<?php

namespace App\Http\Controllers;
use App\SalonSale;
use App\SalonSaleDetails;
use Illuminate\Http\Request;
use Validator;


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
            return response()->json(['success' => false, 'message' => 'Sale is already existed'],200)
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
}
