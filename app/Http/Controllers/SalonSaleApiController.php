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
            'grossSales' => 'nullable|numeric',
            'giftCardSolds' => 'nullable|numeric',
            'giftCardRedeemeds' => 'nullable|numeric',
            'tips' => 'nullable|numeric',
            'convenienceFees' => 'nullable|numeric'
        ];

        //return response()->json(['success'=>true,'input'=>$request->all(),'message'=>'testing']);

        $validator =  Validator::make($request->all(), $rules);

        if($validator->fails()){
            //$errors = $validator->getMessageBag();

            return response()->json(['success' =>false, 'message' => 'error'],422)->header('Content-type','application/json');
        }

        $date = $request->input('date');
        $grossSales = $request->input('grossSales');
        $giftCardSolds =  $request->input('giftCardSolds');
        $giftCardRedeemeds = $request->input('giftCardRedeemeds');
        $tips = $request->input('tips');
        $convenienceFees = $request->input('convenienceFees');



        $sale = SalonSale::updateOrCreate(['date' => $date, 'gross_sales' => $grossSales,
            'giftcard_sold' => $giftCardSolds, 'giftcard_redeemed' => $giftCardRedeemeds, 'tips' => $tips]);

        $salonSaleDetail = new SalonSaleDetails(['item' => 'convenience fee', 'gross_sales' => $convenienceFees,
            'item_sold' => 1]);

        $sale->salonSaleDetails()->save($salonSaleDetail);



        return response()->json(['success' => true, 'message' => 'The sales have been added'],200);
    }
}
