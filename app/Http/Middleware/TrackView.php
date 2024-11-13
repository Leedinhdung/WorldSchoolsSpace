<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $postId = $request->route('id'); // Lấy ID của bài viết từ route
        $viewedPosts = session()->get('viewed_posts', []);

        // Nếu bài viết chưa được xem, tăng view và lưu vào session
        if (!in_array($postId, $viewedPosts)) {
            $post = Post::findOrFail($postId);
            $post->increment('view');

            // Lưu ID của bài viết vào session để không tăng view lại
            session()->push('viewed_posts', $postId);
        }

        return $next($request);
    }
}
