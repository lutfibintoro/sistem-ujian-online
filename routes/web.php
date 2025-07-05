<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegishController;

Route::get('/', function () {
    return view('registrasi.signIn', ['alert_status' => '', 'username' => '', 'alert_message' => '']);
});


// route untuk melakukan sign-up
Route::get('/sign-up', [RegishController::class, 'signUp']);
Route::post('/sign-up', [RegishController::class, 'signUp']);
Route::get('/sign-in/{alert_status}/{username}', [RegishController::class, 'signUpSukses']);


// route untuk melakukan sign-in
Route::post('/sign-in', [RegishController::class, 'signIn']);


// route untuk masuk ke halaman dashboard
Route::get('/dashboard/{username}/{pass}', [RegishController::class, 'dashboard']);


// route untuk di halaman profil, put untuk edit data, get untuk ambil dan tampilkan data
Route::get('/profil/{username}/{pass}', [RegishController::class, 'profil']);
Route::put('/profil/{username}/{pass}/edit', [RegishController::class, 'profil']);


// route untuk guru membuat soal baru
Route::get('/soal/guru/{username}/{pass}', [RegishController::class, 'soalNewMeta']);
Route::post('/soal/guru/{username}/{pass}', [RegishController::class, 'soalNew']);
Route::post('/soal/guru/{username}/{pass}/{id_data_ujian}', [RegishController::class, 'pertanyaanNew']);
Route::get('/soal/guru/{username}/{pass}/{id_data_ujian}', [RegishController::class, 'pertanyaanDel']);
