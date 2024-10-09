<?php

use App\Http\Controllers\api\PostController;
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

Route::get('post', [PostController::class, 'getPost']); // Lấy danh sách bài viết
Route::get('post/popular', [PostController::class, 'getPopularPost']); // Lấy bài viết được xem nhiều nhất
Route::get('post/latest', [PostController::class, 'getLatestPost']); // Lấy bài viết mới nhất
Route::post('post/{id}/comment', [PostController::class, 'postComment']); // Bình luận trên bài viết
Route::post('post/{id}/comment', [PostController::class, 'postComment']); // Bình luận trên bài viết
Route::get('post/{id}/comments', [PostController::class, 'getPostComments']); // Lấy danh sách bình luận
Route::get('post/{id}/share', [PostController::class, 'getShareableLink']); // Chia sẻ qua mạng xã hội
Route::delete('comment/{id}', [PostController::class, 'deleteComment']); // Xóa bình luận