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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* ----------------
|      USER      |
-----------------*/
Route::get('user', 'Users\UserController@tampilUsers');
Route::get('user/{id}', 'Users\UserController@findUserById');
Route::post('user/register', 'Users\UserController@register');
Route::post('user/login', 'Users\UserController@login');
Route::put('user/{id}', 'Users\UserController@editUser');
Route::delete('user/{id}', 'Users\UserController@deleteUser');

// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('user/upload', 'Users\UserController@uploadFoto');
// });


/* ----------------
|      PAKET      |
-----------------*/
Route::get('paket', 'Paket\JenisPaketController@tampilJenisPaket');
Route::get('paket/{id}', 'Paket\JenisPaketController@tampilById');
Route::post('paket', 'Paket\JenisPaketController@tambahPaket');
Route::put('paket/{id}', 'Paket\JenisPaketController@editPaket');

/* ----------------------
|    REGISTRASI PAKET   |
------------------------*/
Route::get('registrasiPaket', 'Paket\registrasiPaketController@tampil');
Route::post('registrasiPaket/{id}', 'Paket\registrasiPaketController@addRegistPaket');
Route::post('registrasiPaket', 'Paket\RegistrasiPaketController@submitRegist')->name('registrasi.store');


/* ----------------
|    PERTANYAAN   |
-----------------*/

Route::get('pertanyaan', 'Pertanyaan\PertanyaanController@tampilPertanyaan');
Route::get('pertanyaan/{id}', 'Pertanyaan\PertanyaanController@tampilById');
Route::get('pertanyaan/tampilPertanyaanByRegistrasiId/{id}', 'Pertanyaan\PertanyaanController@tampilPertanyaanByRegistrasiId');
Route::put('pertanyaan/{id}', 'Pertanyaan\PertanyaanController@editPertanyaan');
Route::post('pertanyaan/postPertanyaan/{id}', 'Pertanyaan\PertanyaanController@postPertanyaan');
Route::delete('pertanyaan/deletePertanyaan/{id}', 'Pertanyaan\PertanyaanController@deletePertanyaan');

/* ---------------------------
|    PERTANYAAN SCREENING   |
----------------------------*/
Route::get('pertanyaanScreening', 'PertanyaanScreening\PertanyaanScreeningController@tampilPertanyaanScreening');
Route::get('pertanyaanScreeningByRegistrasiId/{id}', 'PertanyaanScreening\PertanyaanScreeningController@tampilSemuaPertanyaanByRegistrasiId');
Route::post('pertanyaanScreening/{id}', 'PertanyaanScreening\PertanyaanScreeningController@postPertanyaanScreening');
Route::put('pertanyaanScreening/{id}', 'PertanyaanScreening\PertanyaanScreeningController@editPertanyaanScreening');
Route::delete('pertanyaanScreening/{id}', 'PertanyaanScreening\PertanyaanScreeningController@hapusPertanyaanScreening');

/* --------------------------------
|    JAWAB PERTANYAAN SCREENING   |
---------------------------------*/
Route::get('jawabPertanyaanScreeningByIdPertanyaan/{id}', 'PertanyaanScreening\JawabPertanyaanScreeningController@tampilSemuaJawabanByIdPertanyaan');
Route::get('getjawabByUserIdPertanyaanScreening/{id}', 'PertanyaanScreening\JawabPertanyaanScreeningController@tampilSemuaJawabanByIdUser');
Route::get('getjawabPertanyaanScreening/{id}', 'PertanyaanScreening\JawabPertanyaanScreeningController@getJawabanById');
Route::post('jawabPertanyaanScreening/{id}', 'PertanyaanScreening\JawabPertanyaanScreeningController@postJawaban');


