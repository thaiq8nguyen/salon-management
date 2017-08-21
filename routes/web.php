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
    return view('auth.login');
});

    Route::get('/api-dashboard','ApiDashBoardController@index')->name('api-dashboard');

    Route::get('/salon-sales','SalonSaleController@index')->name('salon-sale');

    Route::get('/salon-sale/create', 'SalonSaleController@create')->name('salon-sale-create');

    Route::get('/technician-sale', 'TechnicianSaleController@index')->name('technician-sale');

    Route::get('/technician-sale/quick-sale-entry','TechnicianSaleController@quickSaleEntry')->name('quick-sale-entry');

    Route::get('/wages/pay', 'WageController@payday')->name('payday');

    /*Technician create sale*/
    Route::get('/technician-sale/add', 'TechnicianSaleController@create')
        ->name('technician-sale-add');
    /*Pay Technicians dashboard*/


    /*Create technician payments*/
    Route::get('/wages/pay/{technician}', 'WagePaymentController@create')->name('create-technician-pay');

    /*Create technician pay period report in PDF*/
    Route::get('/report/{technician}/payment/{payPeriod?}', 'PaymentReportController@show')->name('create-pay-report');

    /*Technician book dashboard*/
    Route::get('/technician-book', 'TechnicianBookController@index')->name('technician-book');

    /*Create a technician book with an opening balance*/
    Route::get('/technician-book/create' , 'TechnicianBookController@create')->name('display-create-book-form');

    Route::get('/technician-book/insert/payments','TechnicianBookController@insertWages')->name('insert-wages-to-book');

    Route::get('/technician-book/insert/sales', 'TechnicianBookController@insertSales')->name('insert-sales-to-book');

    /*Pay a technician with one or more payments*/
    Route::post('/wages/pay/{technician}', 'WagePaymentController@store')->name('pay-technician');

    /*Record a technician sale for a day */
    Route::post('/technician-sale', 'TechnicianSaleController@storeSale')->name('record-technician-sale');

    /*Create a technician opening balance record */
    Route::post('/technician-book/create' , 'TechnicianBookController@store')->name('create-technician-book');

    /*Home page*/
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/logout', 'Auth\LoginController@logout');

    Route::get('/gift-certificate','GiftCertificateController@index');

    //Testing Only -- Route::get('/gift/list','GiftCertificateController@index');





/*Authentication routes*/
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
