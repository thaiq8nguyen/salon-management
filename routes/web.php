<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/technician-sale', 'TechnicianSaleController@index');
Route::get('/technician-sale/date/{saleDate}/technician/{technician}', 'TechnicianSaleController@create');
Route::get('/wages/pay', 'WageController@payday');
Route::get('/wages/pay/{technician}', 'WagePaymentController@create');
Route::get('/report/{technician}/payment/{payPeriod}', 'PaymentReportController@show');
Route::get('/technician-book', 'TechnicianBookController@index');
Route::get('/technician-book/create' , 'TechnicianBookController@create');

Route::post('/wages/pay/{technician}', 'WagePaymentController@store');
Route::post('/technician-sale', 'TechnicianSaleController@storeSale');
Route::post('/technician-book/create' , 'TechnicianBookController@store');


