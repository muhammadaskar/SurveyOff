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


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/user', 'User\UserController@index');
Route::resource('/user', 'User\UserController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'DonationController@index')->name('welcome');
Route::post('/finish', function(){
    return redirect()->route('welcome');
})->name('donation.finish');

Route::post('/donation/store', 'DonationController@submitDonation')->name('donation.store');
Route::post('/notification/handler', 'DonationController@notificationHandler')->name('notification.handler');

Route::post('/finish', function(){
    return redirect()->route('registrasi');
})->name('registrasi.finish');

Route::get('registrasi', 'Paket\registrasiPaketController@index');
Route::post('registrasi/store', 'Paket\registrasiPaketController@submitRegist')->name('registrasi.store');