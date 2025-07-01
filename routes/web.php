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