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
    Route::get('/pay-period/technician-report/','PayPeriodController@report')->name('technician-pay-period-report');

    /*TECHNICIAN ROUTES*/
    Route::get('/technician','TechnicianHomeController@home')->name('technician-home')->middleware('auth');
    Route::get('/technician/sale','TechnicianHomeController@sale')->name('technician-sale')->middleware('auth');
    Route::get('/technician/reports/payment-reports','TechnicianHomeController@paymentReports')->middleware('auth');
    Route::get('/technician/reports/payment-report','TechnicianHomeController@paymentReport')->middleware('auth');

    /*TESTING ROUTES*/
    //Testing Only -- Route::get('/gift-certificate/search/date/{date}','GiftCertificateController@searchByDate');
    //Testing Only -- Route::get('/gift/list','GiftCertificateController@index');
    Route::get('/test/wage-report/preview/{technicianId}/{payPeriodId}','Test\PaymentReportTestController@preview');

    Route::get('/mailable', function () {


        return new App\Mail\Test();

    })->middleware('auth');

    Route::get('/s3',function(){

        Storage::disk('s3')->put('payment.text','world');

    });

    /*Authentication routes*/
    Auth::routes();
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/register','RegistrationController@index');
    Route::post('/register','RegistrationController@register')->name('register');
    Route::get('/post-register','RegistrationController@postRegister')->name('post-register');
    Route::get('/logout', 'Auth\LoginController@logout');



