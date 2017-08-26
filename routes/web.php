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

    /*ADMIN ROUTES*/

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/gift-certificate','GiftCertificateController@index')->name('gift-certificate');
    Route::get('/salon-sales','SalonSaleController@index')->name('salon-sale');
    Route::get('/technician-sale/quick-sale-entry','TechnicianSaleController@quickSaleEntry')->name('quick-sale-entry');
    Route::get('/api-dashboard','ApiDashBoardController@index')->name('api-dashboard');
    Route::get('/wages/pay', 'WageController@payday')->name('payday');
    Route::get('/technician-sale/add', 'TechnicianSaleController@create')
    ->name('technician-sale-add');
    Route::get('/technician-book', 'TechnicianBookController@index')->name('technician-book');

    Route::get('/report/{technician}/payment/{payPeriod?}', 'PaymentReportController@show')->name('create-pay-report');

    /*TECHNICIAN ROUTES*/
    Route::get('/technician','TechnicianHomeController@home')->name('technician-home')->middleware('auth');
    Route::get('/technician/sale','TechnicianHomeController@sale')->name('technician-sale')->middleware('auth');

    /*TESTING ROUTES*/
    //Testing Only -- Route::get('/gift-certificate/search/date/{date}','GiftCertificateController@searchByDate');
    //Testing Only -- Route::get('/gift/list','GiftCertificateController@index');

    /*Authentication routes*/
    Auth::routes();
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/logout', 'Auth\LoginController@logout');



