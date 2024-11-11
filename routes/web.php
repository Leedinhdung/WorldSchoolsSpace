<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
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
    Route::prefix('posts')->as('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/trash', [PostController::class, 'trash'])->name('trash');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::post('ckeditor/upload', [PostController::class, 'upload'])->name('ckeditor.upload');
        Route::get('edit/{id}', [PostController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [PostController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [PostController::class, 'destroy'])->name('destroy');
        Route::get('restore/{id}', [PostController::class, 'restore'])->name('restore');
        Route::get('forcedelete/{id}', [PostController::class, 'forcedelete'])->name('forcedelete');
    });
    //COMMENT
    Route::prefix('comment')->as('comment.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::get('/show/{id}', [CommentController::class, 'show'])->name('show');
        Route::put('/update/{id}', [CommentController::class, 'update'])->name('update');
    });
    //USER
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
    });
    Route::prefix('role')->as('role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        // Route::get('/trash', [PostController::class, 'trash'])->name('trash');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/create', [RoleController::class, 'store'])->name('store');
        Route::get('{id}/show', [RoleController::class, 'show'])->name('show');
        Route::get('{id}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [RoleController::class, 'update'])->name('update');
        Route::get('{id}/delsoft', [RoleController::class, 'delSoft'])->name('delsoft');
        Route::get('{id}/restore', [RoleController::class, 'restore'])->name('restore');
        Route::get('{id}/delete', [RoleController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('permission')->as('permission.')->group(function () {
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/create', [PermissionController::class, 'store'])->name('store');
        Route::get('{id}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [PermissionController::class, 'update'])->name('update');
        Route::get('{id}/delete', [PermissionController::class, 'destroy'])->name('destroy');
    });
});
