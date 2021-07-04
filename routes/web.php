<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
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
    return view('client.pages.home');
});

Route::get('/loginn', function () {
    return view('login');
});
Route::get('/book-detail', function () {
    return view('client.pages.book-detail');
})->name('book-detail');
Route::get('/home', function () {
    return view('client.pages.home');
})->name('homepage');

Route::prefix('admin')->middleware('check-role')->group(function () {
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
    Route::prefix('book')->group(function () {
        Route::get('/',[BookController::class,'index'])->name('book.index');
        Route::get('add-book',[BookController::class,'create'])->name('book.create');
        Route::post('add-book',[BookController::class,'store'])->name('book.store');
        Route::get('remove/{id}',[BookController::class,'destroy'])->name('book.destroy');
        Route::get('edit/{id}',[BookController::class,'edit'])->name('book.edit');
        Route::post('edit/{id}', [BookController::class, 'update'])->name('book.update');

        Route::get('changeStatus', [BookController::class,'changeStatus']);
    });

    Route::prefix('author')->group(function () {
        Route::get('/',[AuthorController::class,'index'])->name('author.index');
        Route::get('add-author',[AuthorController::class,'create'])->name('author.create');
        Route::post('add-author',[AuthorController::class,'store'])->name('author.store');
        Route::get('remove/{id}',[AuthorController::class,'destroy'])->name('author.destroy');
        Route::get('edit/{id}',[AuthorController::class,'edit'])->name('author.edit');
        Route::post('edit/{id}', [AuthorController::class, 'update'])->name('author.update');
    });
});


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
