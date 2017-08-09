<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician;
use Validator;
use App\TechnicianSale;
use App\PayPeriod;
class TechnicianSaleApiController extends Controller
{
    public function addSale(Request $request){

        $validator =  Validator::make($request->all(),[
            'technicianID' => 'required',
            'saleDate' =>'required|date',
            'sale' => 'required|numeric',
            'tip' => 'numeric'
        ]);

        $technician = Technician::find($request->input('technicianID'));

        $saleDate = $request->input('saleDate');

        if($validator->fails()){
            $error = $validator->getMessageBag();

            return response()->json(['success' => false, 'message'=> $error],422)->header('Content-type', 'application/json');
        }

        $sale = TechnicianSale::create(['technician_id' => $request->input('technicianID'),'sale_date' => $saleDate,
            'sales' => $request->input('sale') ,'additional_sales' => $request->input('tip')]);

        return response()->json(['success'=> true, 'message'=> $technician->first_name . '\'s sales has been added for ' . $sale->sale_date_mdy],200)
            ->header('Content-type','application/json');
    }
    public function handleQuickSale(Request $request){

        $technicianSales = $request->input('sales');


        foreach($technicianSales as $technicianSale){
            $existingSaleID = $technicianSale['existing_sale_id'];
            $toBeDeleted = $technicianSale['toBeDeleted'];
            unset($technicianSale['existing_sale_id']);

            if($existingSaleID){
                $sale = TechnicianSale::find($existingSaleID);
                if(!$toBeDeleted){

                    $sale->update($technicianSale);

                }else{

                    $sale->destroy($existingSaleID);

                }
            }
            else{
                $sale = new TechnicianSale($technicianSale);
                $technician = Technician::find($technicianSale['technician_id']);
                $technician->sales()->save($sale);
            }


        }


        return response()->json(['success'=>true]);

    }
    public function editSale(Request $request){

        $validator =  Validator::make($request->all(),[
            'saleID' =>'required',
            'sale' => 'nullable|numeric|between:1,1000',
            'tip' => 'nullable|numeric|between:1,1000'
        ]);

        if($validator->fails()){
            $errors = $validator->getMessageBag();
            return response()->json(['success' => false, 'message' => $errors],422)
                ->header('Content-type', 'application/json');
        }

        $sale = TechnicianSale::find($request->input('saleID'));

        if($request->has('sale')){
            $sale->sales = $request->input('sale');
        }
        if($request->has('tip')){
            $sale->additional_sales = $request->input('tip');
        }
        $saleDate = $sale->sale_date_mdy;

        $sale->update();

        return response()->json(['success' => true, 'message' => 'Sale has been updated for ' . $saleDate,
            'sale' => $sale->sales_amount, 'additionalSale' => $sale->additional_sales_amount],200)
            ->header('Content-type', 'application/json');

    }

    /**
     * @param PayPeriod $payPeriod
     * @param Technician $technician
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSaleByPeriod(PayPeriod $payPeriod, Technician $technician){


        $technicianID = $technician->id; //get technician ID

        $technician = Technician::with(['dailySales' =>
            function($query) use ($payPeriod){

                $query->whereBetween('sale_date',[$payPeriod->begin_date, $payPeriod->end_date]);

            }])->where('id', '=', $technicianID)->first();


        return response()->json(['daily_sales'=>$technician->dailySales,'full_name'=>$technician->full_name, 'id'=>$technician->id],
            200)->header('Content-type','application/json');

    }

    public function searchSaleByDate(Request $request)
    {
        $rules = [
            'saleDate' => 'required'
        ];
        $message = [
            'required' => 'Sale date is required',

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
                'countSales' => $technician->countSales,'saleDate' => $saleDate];

        }

        return response()->json(['success' => true, 'technicians' => $response, 'saleDate' => $saleDate], 200)
            ->header('Content-type', 'application/json');
    }

    public function getSaleByDate(Request $request){

        $saleDate = $request->input('saleDate');

        $technicians = Technician::with(['dailySales' => function($query) use ($saleDate){
            $query->where('sale_date', $saleDate);
        }])->orderBy('last_name', 'asc')->get();

        $response = [];

        foreach($technicians as $technician){
            $response[] = ['technicianID'=>$technician->id,'fullName' => ucfirst($technician->fullName), 'dailySales' => $technician->dailySales];

        }

        return response()->json(['success'=>true,'technicians'=>$response],200)
            ->header('Content-type','application/json');

    }


}
