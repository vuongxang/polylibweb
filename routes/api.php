<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('order-data', [AdminController::class, 'ordersData']);

Route::get('order-data-month', [AdminController::class, 'ordersDataMonth']);

Route::get('reset-password', [ResetPasswordController::class, 'resetForm'])->name('resetPassword');
Route::post('reset-password', [ResetPasswordController::class,'sendMail']);
Route::put('reset-password/{token}', [ResetPasswordController::class,'reset']);