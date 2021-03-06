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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Begin Auth
Route::post('/login', 'AuthenticationController@login');
Route::post('/register', 'AuthenticationController@register');


Route::group(['middleware' => 'auth:api'], function () {
    // Auth
    Route::post('/logout', 'AuthenticationController@logout');

    // Technician CRUD
    Route::get('/technicians', 'TechnicianController@get');
    Route::post('/technicians', 'TechnicianController@add');
    Route::put('/technicians/{id}', 'TechnicianController@update');
    Route::delete('/technicians/{id}', 'TechnicianController@delete');

    // Technician Sales CRUD
    Route::get('/technicians/sales', 'TechnicianSaleController@getAllTechnicianSales');
    Route::get('/technicians/{technicianId}/sales', 'TechnicianSaleController@getTechnicianSale');
    Route::post('/technicians/sales', 'TechnicianSaleController@addTechnicianSale');
    Route::put('/technicians/sales/{saleId}', 'TechnicianSaleController@updateTechnicianSale');
    Route::delete('/technicians/sales/{saleId}', 'TechnicianSaleController@deleteTechnicianSale');

    // PayPeriod CRUD
    Route::get('/pay-periods', 'PayPeriodController@getPayPeriods');

    // Payday
    Route::get('/pay-periods/{payPeriodId}/technicians/{technicianId}/sales', 'PayPeriodController@getTechnicianSales');
    Route::get('/pay-periods/{payPeriodId}/technicians/sales', 'PayPeriodController@getAllTechnicianSales');
    Route::get('/pay-periods/{payPeriodId}/technicians/{technicianId}/earnings', 'PayPeriodController@getTechnicianEarning');
    Route::get('/pay-periods/{payPeriodId}/technicians/earnings', 'PayPeriodController@getAllTechnicianEarnings');

    // Payment Method CRUD
    Route::get('/payment-methods', 'PaymentMethodController@getAllPaymentMethods');

});


// End Auth


/*****Test API*****/
// Route::get('/salon/square-test/metric', function(){
//     $dailySale = Square::getDailySaleMetrics();

//     return response()->json($dailySale);
// })->middleware('auth:api');
// Route::get('/salon/square-test/raw-payments', function(){

//     $beginDate =  \Carbon\Carbon::now()->startOfDay();
//     $newDate = clone $beginDate;

//     $endDate=  $newDate->addDay();
//     $dates = http_build_query(['begin_time' => $beginDate->toIso8601String(),
//         'end_time' => $endDate->toIso8601String()]);
//     $payments = Square::getRawPayments($dates);

//     return response()->json($payments);
// })->middleware('auth:api');
