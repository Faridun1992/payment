<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(PaymentController::class)->group(function (){
    Route::post('/payment-signature', 'handleCallbackFirst');
    Route::post('/payment-hash', 'handleCallbackSecond');
});
