<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookDetailController;
use App\Http\Controllers\FileController;
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

Route::get('book-cate-data', [AdminController::class, 'BookCateDatas']);

Route::Post('comment',[BookDetailController::class,'getComment'])->name('book.comment');

Route::Post('comment-child',[BookDetailController::class,'getCommentChild'])->name('book.comment.child');
Route::Post('rate',[BookDetailController::class,'getRate'])->name('book.rate');
Route::post('convert-file', [FileController::class, 'store'])->name('file.convertStore');