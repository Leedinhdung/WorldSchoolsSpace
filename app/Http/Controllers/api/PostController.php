<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Lấy danh sách bài viết theo ngày đăng
    public function getPost(Request $request)
    {
        $post = Post::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($post);
    }

    // Lấy danh sách bài viết được xem nhiều nhất
    public function getPopularPost(Request $request)
    {
        $posts = Post::where('is_active', 1) // Chỉ lấy bài viết đang hoạt động
            ->orderBy('views', 'desc')
            ->paginate(10);

        if ($posts->isEmpty()) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }

        return response()->json($posts);
    }


    // Lấy danh sách bài viết mới nhất
    public function getLatestPost(Request $request)
    {
        $post = Post::latest()->paginate(10);
        return response()->json($post);
    }

    // Thêm bình luận vào bài viết
    public function postComment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $comment = new Comment();
        $comment->post_id = $id;
        $comment->user_id = $validatedData['user_id'];
        $comment->content = $validatedData['content'];
        $comment->save();

        return response()->json(['message' => 'Thêm bình luận thành công']);
    }

    // Lấy danh sách người bình luận cho một bài viết
    // Route: GET /api/post/{id}/comments
    public function getPostComments($id)
    {
        $comments = Comment::where('post_id', $id)
            ->with('user') // Lấy thông tin người dùng đã bình luận
            ->get();

        return response()->json($comments);
    }

    //Chia sẻ bài viết qua mạng xã hội
    public function getShareableLink($id)
    {
        $post = Post::findOrFail($id);
        $shareLink = url("/post/{$id}");

        return response()->json([
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($shareLink),
        ]);
    }

    //Xóa bình luận
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Xóa bình luận thành công!']);
    }


    // Hàm lấy chi tiết bài viết
    public function getDetailPost($id, $slug)
    {
        $post = Post::with(['category', 'user', 'tags', 'comments'])
            ->where('id', $id)
            ->where('slug', $slug) // Đảm bảo slug cũng khớp
            ->first();

        if (!$post) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }

        return response()->json($post);
    }
    

    public function getPostsByCategory(Category $category)
    {
        $posts = $category->posts()->get();

        return response()->json([
            'category' => $category->name,
            'posts' => $posts,
        ]);
    }
}
