<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('filemanager',[AdminController::class,'fileManager'])->name('filemanager');

    Route::prefix('cate')->group(function () {
        Route::get('/',[CategoryController::class,'index'])->name('cate.index');
        Route::get('add-cate',[CategoryController::class,'create'])->name('cate.create');
        Route::post('add-cate',[CategoryController::class,'store'])->name('cate.store');
        Route::get('remove/{id}',[CategoryController::class,'destroy'])->name('cate.destroy');
        Route::get('edit/{id}',[CategoryController::class,'edit'])->name('cate.edit');
        Route::post('edit/{id}', [CategoryController::class, 'update'])->name('cate.update');

        Route::get('changeStatus', [CategoryController::class,'changeStatus']);
});

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);