<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', function(){
    return 'Hello World from the API route!';
})->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::put('/technician-sale/change', 'TechnicianSaleApiController@changeSale');
Route::get('/technician-sale/search', 'TechnicianSaleController@searchByDate');

Route::get('/pay-period/current', 'PayPeriodApiController@current');

Route::get('/technician-sale/all/', 'TechnicianSaleApiController@searchSaleByDate');
Route::post('/salon-sale/store/','SalonSaleApiController@createSale');