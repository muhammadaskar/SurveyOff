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

Route::get('/user', 'User\UserController@index');
Route::resource('/user', 'User\UserController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/finish', function(){
    return redirect()->route('registrasi');
})->name('registrasi.finish');

Route::get('registrasi', 'Paket\RegistrasiPaketController@index');

Route::post('/registrasi/store', 'Paket\RegistrasiPaketController@submitRegist')->name('registrasi.store');
Route::post('/notification/handler', 'Paket\RegistrasiPaketController@notificationHandler')->name('notification.handler');