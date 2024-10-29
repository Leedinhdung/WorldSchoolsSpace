<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category', [CategoryController::class, 'getCategories']); // Lấy danh sách bài viết


Route::get('post', [PostController::class, 'getPost']); // Lấy danh sách bài viết
Route::get('post/{slug}', [PostController::class, 'getDetailPost']); // Lấy danh sách bài viết
Route::get('post/popular', [PostController::class, 'getPopularPost']); // Lấy bài viết được xem nhiều nhất
Route::get('post/latest', [PostController::class, 'getLatestPost']); // Lấy bài viết mới nhất
Route::post('post/{id}/comment', [PostController::class, 'postComment']); // Bình luận trên bài viết
Route::post('post/{id}/comment', [PostController::class, 'postComment']); // Bình luận trên bài viết
Route::get('post/{id}/comments', [PostController::class, 'getPostComments']); // Lấy danh sách bình luận
Route::get('post/{id}/share', [PostController::class, 'getShareableLink']); // Chia sẻ qua mạng xã hội
Route::delete('comment/{id}', [PostController::class, 'deleteComment']); // Xóa bình luận


Route::get('login/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);


// Các route không yêu cầu xác thực
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']); // Đăng ký người dùng
    Route::post('login', [AuthController::class, 'login']);       // Đăng nhập để nhận JWT token
});

// Các route yêu cầu xác thực JWT
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    // Các route khác cần xác thực JWT
});


Route::middleware('auth:api')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/{id}/promote', [UserController::class, 'promoteToPoster']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::get('users/search', [UserController::class, 'search']);
});
