<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.comments.';
    public function index()
    {
        $title = 'Bình luận';
        $posts = Post::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function show(string $id)
    {
        $title = 'Danh sách bình luận ';
        // Tìm bài viết theo ID và lấy các bình luận đi kèm
        $post = Post::find($id);
        $comments = $post->comments;
        // dd($comments);
        // Trả về view kèm theo dữ liệu bài viết và bình luận
        return view(self::PATH_VIEW . __FUNCTION__, compact('comments', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id); // Tìm bình luận theo ID
        $comment->is_hidden = !$comment->is_hidden; // Đảo ngược trạng thái ẩn
        $comment->save(); // Lưu thay đổi

        return redirect()->back()->with('success', 'Trạng thái bình luận đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
