<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'index'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
});
Route::prefix('admin')->middleware('admin')->as('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //BANNER
    Route::prefix('banner')->as('banner.')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/trash', [BannerController::class, 'trash'])->name('trash');
        Route::get('create', [BannerController::class, 'create'])->name('create');
        Route::post('store', [BannerController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [BannerController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [BannerController::class, 'destroy'])->name('destroy');
        Route::get('restore/{id}', [BannerController::class, 'restore'])->name('restore');
        Route::get('forcedelete/{id}', [BannerController::class, 'forcedelete'])->name('forcedelete');
    });

    //CATEGORY
    Route::prefix('categories')->as('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('restore/{id}', [CategoryController::class, 'restore'])->name('restore');
        Route::get('forcedelete/{id}', [CategoryController::class, 'forcedelete'])->name('forcedelete');
    });

    //POST
    Route::prefix('post')->as('post.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('create', [PostController::class, 'create'])->name('create');
    });
});
