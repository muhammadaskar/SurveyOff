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

// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('user/upload', 'Users\UserController@uploadFoto');
// });

/* TAMBAHKAN SLASH API PADA LINK 
    CONTOH : - LINK UNTUK GET USER BY ID
             http://localhost:8000/api/user/9
*/

/* ----------------
|      USER      |
-----------------*/
Route::get('user', 'Users\UserController@tampilUsers');
Route::get('user/{id}', 'Users\UserController@findUserById');
Route::post('user/register', 'Users\UserController@register');
Route::post('user/login', 'Users\UserController@login');
Route::put('user/{id}', 'Users\UserController@editUser');
Route::delete('user/{id}', 'Users\UserController@deleteUser');

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
Route::post('pertanyaan/postPertanyaan/{id}', 'Pertanyaan\PertanyaanController@postPertanyaan');
Route::put('pertanyaan/{id}', 'Pertanyaan\PertanyaanController@editPertanyaan');
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
Route::put('jawabPertanyaanScreening/update/{id}', 'PertanyaanScreening\JawabPertanyaanScreeningController@editJawabanById');
Route::delete('jawabPertanyaanScreening/{id}', 'PertanyaanScreening\JawabPertanyaanScreeningController@hapusJawabanById');

/* -------------------------
|    JAWAB PERTANYAAN    |
--------------------------*/
Route::get('jawabPertanyaanByIdPertanyaan/{id}', 'Pertanyaan\JawabPertanyaanController@tampilSemuaJawabanByIdPertanyaan');
Route::get('jawabPertanyaanById/{id}', 'Pertanyaan\JawabPertanyaanController@getJawabanById');
Route::post('jawabPertanyaanByIdPertanyaan/post/{id}', 'Pertanyaan\JawabPertanyaanController@postJawaban');
Route::put('jawabPertanyaanById/update/{id}', 'Pertanyaan\JawabPertanyaanController@editJawabanById');
Route::delete('jawabPertanyaanById/delete/{id}', 'Pertanyaan\JawabPertanyaanController@hapusJawabanById');

/* -------------------------
|       ---HASIL---       |
--------------------------*/
Route::get('hasilPertanyaan/{id}', 'Hasil\HasilController@tampilJawabanDanPertanyaanByIdPertanyaan');
Route::get('hasilPertanyaanByIdUser/{id}', 'Hasil\HasilController@tampilJawabanDanPertanyaanByIdUser');
Route::delete('hasilPertanyaan/{id}', 'Hasil\HasilController@deleteJawabanById');

/* --------------------------------
|       ---RESPONDEN---         |
---------------------------------*/
Route::get('responden', 'Responden\RespondenController@tampilSemuaResponden');
Route::get('responden/{id}', 'Responden\RespondenController@getRespondenById');
Route::post('responden/post/{id}', 'Responden\RespondenController@postResponden');
Route::put('responden/update/{id}', 'Responden\RespondenController@editRespondenBydId');
Route::delete('responden/delete/{id}', 'Responden\RespondenController@deleteResponden');



