<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician;
use Validator;
use App\TechnicianSale;
class TechnicianSaleApiController extends Controller
{
    public function changeSale(Request $request){

        $validator =  Validator::make($request->all(),[
            'sale-id' =>'required',
            'sale' => 'nullable|numeric|between:1,1000',
            'additional-sale' => 'nullable|numeric|between:1,1000'
        ]);

        if($validator->fails()){
            $errors = $validator->getMessageBag();
            return response()->json(['success' => false, 'message' => $errors],422)
                ->header('Content-type', 'application/json');
        }

        $sale = TechnicianSale::find($request->input('sale-id'));

        if($request->has('sale')){
            $sale->sales = $request->input('sale');
        }
        if($request->has('additional-sale')){
            $sale->additional_sales = $request->input('additional-sale');
        }
        $saleDate = $sale->sale_date_mdy;

        $sale->update();

        return response()->json(['success' => true, 'message' => 'SalonSaleAPI has been updated for ' . $saleDate,
            'sale' => $sale->sales_amount, 'additionalSale' => $sale->additional_sales_amount],200)
            ->header('Content-type', 'application/json');

    }


    public function searchSaleByDate(Request $request)
    {
        $rules = [
            'saleDate' => 'required|date_format:Y-m-d'
        ];
        $message = [
            'required' => 'SalonSaleAPI date is required',
            'date_format' => "SalonSaleAPI date does not have the correct format (Month/Day/Year)"

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            $errors = $validator->getMessageBag();
            return response()->json(['success' => false, 'message' => $errors], 422)
                ->header('Content-type', 'application/json');
        }

        $saleDate = $request->input('saleDate');


        $technicians = Technician::with(['countSales' => function($query) use ($saleDate){
            $query->where('sale_date', $saleDate);
        }])->orderBy('last_name', 'asc')->get();

        $response = [];
        foreach($technicians as $technician){
            $response[] = ['fullName' => ucfirst($technician->fullName), 'firstName' => ucfirst($technician->first_name),
                'countSales' => $technician->countSales];

        }

        return response()->json(['success' => true, 'technicians' => $response, 'saleDate' => $saleDate], 200)->header('Content-type', 'application/json');
    }
}
