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
Route::post('user/register', 'Users\UserController@register');
Route::delete('user/{id}', 'Users\UserController@deleteUser');


/* ----------------
|      PAKET      |
-----------------*/
Route::get('paket', 'Paket\JenisPaketController@tampilJenisPaket');
Route::post('paket', 'Paket\JenisPaketController@tambahPaket');
Route::put('paket/{id}', 'Paket\JenisPaketController@editPaket');

/* ----------------------
|    REGISTRASI PAKET   |
------------------------*/
Route::get('registrasiPaket', 'Paket\registrasiPaketController@tampil');
Route::post('registrasiPaket/{id}', 'Paket\registrasiPaketController@addRegistPaket');


/* ----------------------
|    JUDUL DESKRIPSI   |
------------------------*/
Route::get('pertanyaan/judulDeskripsi/{id}', 'Pertanyaan\PertanyaanController@tampilJudulDeskripsi');
Route::post('pertanyaan/judulDeskripsi/{id}', 'Pertanyaan\PertanyaanController@addJudulDeskripsi');
Route::put('pertanyaan/judulDeskripsi/{id}', 'Pertanyaan\PertanyaanController@editJudulDeskripsi');
/* ----------------
|    PERTANYAAN   |
-----------------*/

Route::get('pertanyaan', 'Pertanyaan\PertanyaanController@tampilPertanyaan');
Route::post('pertanyaan/postPertanyaan/{id}', 'Pertanyaan\PertanyaanController@postPertanyaan');
Route::delete('pertanyaan/deletePertanyaan/{id}', 'Pertanyaan\PertanyaanController@deletePertanyaan');

/* ---------------------------
|    PERTANYAAN SCREENING   |
----------------------------*/
Route::get('pertanyaanScreening', 'PertanyaanScreening\PertanyaanScreeningController@tampilPertanyaanScreening');
Route::post('pertanyaanScreening/{id}', 'PertanyaanScreening\PertanyaanScreeningController@postPertanyaanScreening');
Route::put('pertanyaanScreening/{id}', 'PertanyaanScreening\PertanyaanScreeningController@editPertanyaanScreening');






