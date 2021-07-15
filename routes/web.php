<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomeController;
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

Route::get('/', [HomeController::class,'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/book-detail/{id}',[ BookController::class,'bookDetail'])->middleware('auth')->name('book.detail');


Route::prefix('admin')->middleware('check-role')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('filemanager', [AdminController::class, 'fileManager'])->name('filemanager');

    Route::prefix('cate')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('cate.index');
        Route::get('add-cate', [CategoryController::class, 'create'])->name('cate.create');
        Route::post('add-cate', [CategoryController::class, 'store'])->name('cate.store');
        Route::get('remove/{id}', [CategoryController::class, 'destroy'])->name('cate.destroy');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('cate.edit');
        Route::post('edit/{id}', [CategoryController::class, 'update'])->name('cate.update');

        Route::get('changeStatus', [CategoryController::class, 'changeStatus']);
        Route::get('trash-list', [CategoryController::class, 'trashList'])->name('cate.trashlist');
        Route::get('restore/{id}', [CategoryController::class, 'restore'])->name('cate.restore');
        Route::get('force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('cate.forcedelete');
        Route::get('changePageSize', [CategoryController::class, 'changePageSize']);
    });
    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('book.index');
        Route::get('add-book', [BookController::class, 'create'])->name('book.create');
        Route::post('add-book', [BookController::class, 'store'])->name('book.store');
        Route::get('remove/{id}', [BookController::class, 'destroy'])->name('book.destroy');
        Route::get('edit/{id}', [BookController::class, 'edit'])->name('book.edit');
        Route::post('edit/{id}', [BookController::class, 'update'])->name('book.update');
        Route::get('changeStatus', [BookController::class, 'changeStatus']);
    });

    Route::prefix('author')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('author.index');
        Route::get('add-author', [AuthorController::class, 'create'])->name('author.create');
        Route::post('add-author', [AuthorController::class, 'store'])->name('author.store');
        Route::get('remove/{id}', [AuthorController::class, 'destroy'])->name('author.destroy');
        Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('author.edit');
        Route::post('edit/{id}', [AuthorController::class, 'update'])->name('author.update');
        Route::get('trash-list', [AuthorController::class, 'trashList'])->name('author.trashlist');
        Route::get('restore/{id}', [AuthorController::class, 'restore'])->name('author.restore');
        Route::get('force-delete/{id}', [AuthorController::class, 'forceDelete'])->name('author.forcedelete');
        Route::get('changePageSize', [AuthorController::class, 'changePageSize']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('is-admin')->name('user.index');
        Route::get('client',[UserController::class,'ListClient'])->name('user.client');
        // Route::post('add-author',[AuthorController::class,'store'])->name('author.store');
        // Route::get('remove/{id}',[AuthorController::class,'destroy'])->name('author.destroy');
        // Route::get('edit/{id}',[AuthorController::class,'edit'])->name('author.edit');
        // Route::post('edit/{id}', [AuthorController::class, 'update'])->name('author.update');
    });
});


Auth::routes();



Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
