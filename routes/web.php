<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostShareCategoryController;
use App\Http\Controllers\PostShareController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/book-detail/{slug}', [BookController::class, 'bookDetail'])->name('book.detail');
    Route::get('/author/{id}', [AuthorController::class, 'authorDetail'])->name('author.detail');
    Route::get('/read/{slug}', [BookController::class, 'readingBook'])->name('book.read');
    Route::get('/review-book/{slug}', [BookController::class, 'reviewBook'])->name('book.review');
    Route::get('/category', [BookController::class, 'getBooks'])->name('book.categories');
    Route::get('/category/{slug}', [BookController::class, 'getBooksByCategory'])->name('book.category');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/{id}', [SearchController::class, 'search'])->name('searchID');
    Route::get('/filter', [SearchController::class, 'filter'])->name('filter');
    Route::post('/searchapi', [SearchController::class, 'searchApi'])->name('searchapi');
    Route::get('/category-postshare', [PostShareController::class, 'all'])->name('post.categories');
    Route::get('/add-post', [PostShareController::class, 'create'])->name('post.create');
    Route::post('/add-post', [PostShareController::class, 'store'])->name('post.store');
    Route::get('/edit-post/{id}', [PostShareController::class, 'edit'])->name('post.edit');
    Route::get('/post-detail/{slug}', [PostShareController::class, 'detail'])->name('post.detail');
    Route::get('/delete-post/{slug}', [PostShareController::class, 'destroy'])->name('post.destroy');
});
Route::get('contact', [ContactController::class, 'contact'])->name('contact');
Route::post('contact', [ContactController::class, 'postContact'])->name('contact');

Route::get('profile/{id}', [HomeController::class, 'profile'])->middleware('auth')->name('client.profile');
Route::post('infomation/{id}', [HomeController::class, 'edit_infomation'])->middleware('auth')->name('infomation.edit');

// Route::view('review', 'client.pages.review-book');
Route::post('/comment-store', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::get('history/{id}', [HomeController::class, 'history'])->middleware('auth')->name('user.history');
Route::get('my-posts/{id}', [PostShareController::class, 'myPost'])->middleware('auth')->name('user.myPost');
Route::get('setting', [HomeController::class, 'setting'])->middleware('auth')
    ->name('user.setting');
Route::get('rate/{id}', [HomeController::class, 'rate'])->middleware('auth')
    ->name('user.rate');
Route::get('help', [HomeController::class, 'help'])->middleware('auth')
    ->name('user.help');
Route::get('book-order/{id}', [CartController::class, 'getAddCart'])->name('Book.Order');
Route::get('deleted-book/{id}', [CartController::class, 'deleted_book'])->name('deleted.book');
Route::post('/rating', [BookController::class, 'bookStar'])->middleware('auth')->name('bookStar');
Route::get('book-rate/{id}', [BookController::class, 'rateBook'])->name('book.rate');

Route::get('notification-read/{id}', [UserController::class, 'readeNotification'])->name('notification.read');
Route::get('notifies-read', [UserController::class, 'readAllNotify'])->name('notifications.read');
Route::get('notifications', [UserController::class, 'notifications'])->name('notifications');
Route::post('post/api/tang-view', [PostShareController::class, 'updateView'])->name('post.updateView');
//Route admin
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
    Route::prefix('post-cate')->group(function () {
        Route::get('/', [PostShareCategoryController::class, 'index'])->name('postCate.index');
        Route::get('add-cate', [PostShareCategoryController::class, 'create'])->name('postCate.create');
        Route::post('add-cate', [PostShareCategoryController::class, 'store'])->name('postCate.store');
        Route::get('remove/{id}', [PostShareCategoryController::class, 'destroy'])->name('postCate.destroy');
        Route::get('edit/{id}', [PostShareCategoryController::class, 'edit'])->name('postCate.edit');
        Route::post('edit/{id}', [PostShareCategoryController::class, 'update'])->name('postCate.update');

        Route::get('changeStatus', [PostShareCategoryController::class, 'changeStatus']);
        Route::get('trash-list', [PostShareCategoryController::class, 'trashList'])->name('postCate.trashlist');
        Route::get('restore/{id}', [PostShareCategoryController::class, 'restore'])->name('postCate.restore');
        Route::get('force-delete/{id}', [PostShareCategoryController::class, 'forceDelete'])->name('postCate.forcedelete');
        Route::get('changePageSize', [PostShareCategoryController::class, 'changePageSize']);
    });
    Route::prefix('post-share')->group(function () {
        Route::get('/', [PostShareController::class, 'index'])->name('post.index');
        Route::get('post-share-approv/{id}', [PostShareController::class, 'postApprov'])->name('post.approv');
        Route::get('post-share-refuse/{id}', [PostShareController::class, 'postRefuse'])->name('post.refuse');

    });
    Route::prefix('book')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('book.index');
        Route::get('add-book', [BookController::class, 'create'])->name('book.create');
        Route::post('add-book', [BookController::class, 'store'])->name('book.store');
        Route::get('remove/{id}', [BookController::class, 'destroy'])->name('book.destroy');
        Route::get('edit/{id}', [BookController::class, 'edit'])->name('book.edit');
        Route::post('edit/{id}', [BookController::class, 'update'])->name('book.update');
        Route::get('changeStatus', [BookController::class, 'changeStatus']);
        Route::get('trash-list', [BookController::class, 'trashList'])->name('book.trashlist');
        Route::get('restore/{id}', [BookController::class, 'restore'])->name('book.restore');
        Route::get('force-delete/{id}', [BookController::class, 'forceDelete'])->name('book.forcedelete');
        Route::get('changePageSize', [BookController::class, 'changePageSize']);
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

    Route::prefix('user')->middleware('is-admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('client', [UserController::class, 'ListClient'])->name('user.client');
        // Route::post('add-author',[AuthorController::class,'store'])->name('author.store'); 
        Route::get('add-user', [UserController::class, 'create'])->name('user.create');
        Route::post('add-user', [UserController::class, 'store'])->name('user.store');
        Route::get('remove/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('edit/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('restore/{id}', [UserController::class, 'restore'])->name('user.restore');
        Route::get('force-delete/{id}', [UserController::class, 'forceDelete'])->name('user.forcedelete');
    });

    Route::prefix('profile')->middleware('auth')->group(function () {
        Route::get('my-profile/{id}', [UserController::class, 'profile'])->name('user.profile');
        Route::post('my-profile/{id}', [UserController::class, 'updateProfile'])->name('user.profile');
    });

    Route::prefix('comment')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('comment.index');
        Route::get('comment-approv/{id}', [CommentController::class, 'commentApprov'])->name('comment.approv');
        Route::get('remove/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
        Route::get('restore/{id}', [CommentController::class, 'restore'])->name('comment.restore');
        Route::get('force-delete/{id}', [CommentController::class, 'forceDelete'])->name('comment.forcedelete');
    });

    Route::prefix('review')->group(function () {
        Route::get('/', [RatingController::class, 'index'])->name('rate.index');
        Route::get('rate-approv/{id}', [RatingController::class, 'rateApprov'])->name('rate.approv');
        Route::get('remove/{id}', [RatingController::class, 'destroy'])->name('rate.destroy');
        Route::get('restore/{id}', [RatingController::class, 'restore'])->name('rate.restore');
        Route::get('force-delete/{id}', [RatingController::class, 'forceDelete'])->name('rate.forcedelete');
    });
    Route::prefix('file')->group(function () {
        Route::get('convert-file', [FileController::class, 'convertForm'])->name('file.convertForm');
        Route::post('convert-file', [FileController::class, 'store'])->name('file.convertStore');
    });
});


//Route Auth
// Auth::routes();
Auth::routes([
    'register' => true, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('admin-login', [App\Http\Controllers\Auth\LoginController::class, 'loginForm'])->name('adminLoginForm');
Route::post('admin-login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('adminLogin');

Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);
