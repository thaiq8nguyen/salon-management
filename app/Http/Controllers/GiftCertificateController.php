<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Salon\GiftCertificates\Gift;
use Carbon\Carbon;
use Salon\Square\Square;


class GiftCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){

        return view('salon/gift-certificate',['pageTitle' => 'Gift Certificate','defaultNavBar' => false]);

    }

    public function recent(){

        $gifts = Gift::getRecentGifts();

        return response()->json($gifts, 200)->header('Content-type','application/json');
    }

    public function useGift(Request $request){

        $result = Gift::useGift($request->input('detail'), $request->input('id'));

        return response()->json($result,200)->header('Content-type', 'application/json');
    }

    public function voidGift(Request $request){

        $result = Gift::voidGift($request->input('id'));

        return response()->json($result,200)->header('Content-type', 'application/json');
    }

    public function search(Request $request){
        if($request->has('date')){
            $result = Gift::search($request->input('squareId'), $request->input('date'));
        }
        else{
            $result = Gift::search($request->input('squareId'),null);
        }



        return response()->json($result);

    }


}
