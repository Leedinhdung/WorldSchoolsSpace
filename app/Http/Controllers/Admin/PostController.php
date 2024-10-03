<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('track.view')->only('show');
    }

    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.posts.';
    const PATH_UPLOAD = 'posts';
    public function index()
    {
        $title = 'Danh sách bài viết';
        $posts = Post::whereNull('deleted_at')->get();
        $totalPosts = Post::whereNull('deleted_at')->count();
        $trashedPosts = Post::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'posts', 'totalPosts', 'trashedPosts'));
    }

    public function trash()
    {
        $title = 'Thùng rác';
        $trashedPosts = Post::onlyTrashed()->get();
        $totalTrashedPosts = Post::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'trashedPosts', 'totalTrashedPosts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm bài viết';

        // Lấy tất cả các danh mục, bao gồm cả những danh mục cha đã bị xóa mềm
        $categories = Category::withTrashed()->get();

        // Xây dựng cây danh mục nhưng bỏ qua các danh mục cha đã bị xóa mềm
        $categoryTree = Category::buildCategoryTree($categories, null, true); // Thêm tham số để bỏ qua danh mục cha bị xóa mềm


        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'categoryTree'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            // Lưu ảnh vào thư mục tạm `storage/app/public/tmp_uploads`
            $request->file('upload')->move(storage_path('app/public/tmp_uploads'), $fileName);

            // Trả về URL của ảnh tạm
            $url = asset('storage/tmp_uploads/' . $fileName);

            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'Không thể tải ảnh lên']
        ]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('image');
            $data['user_id'] = Auth::user()->id;
            $data['is_active'] ??= 0;
            $data['status'] = 'pending';

            $content = $data['content'];

            // Tìm tất cả các ảnh trong nội dung (dùng regex để tìm URL ảnh)
            preg_match_all('/src="([^"]*)"/', $content, $matches);
            $imagePaths = $matches[1]; // Mảng chứa URL các ảnh tạm

            foreach ($imagePaths as $tmpImageUrl) {
                // Loại bỏ phần asset URL để lấy tên file
                $tmpImagePath = str_replace(asset('storage/tmp_uploads/'), '', $tmpImageUrl);
                $newImagePath = 'uploads/' . basename($tmpImagePath);

                // Kiểm tra sự tồn tại của ảnh tạm và di chuyển
                if (Storage::disk('public')->exists('tmp_uploads/' . $tmpImagePath)) {
                    Storage::disk('public')->move('tmp_uploads/' . $tmpImagePath, $newImagePath);

                    // Thay thế URL tạm bằng URL mới trong nội dung
                    $content = str_replace($tmpImageUrl, asset('storage/' . $newImagePath), $content);
                } else {
                    throw new \Exception('Ảnh tạm không tồn tại: ' . $tmpImageUrl);
                }
            }

            // Cập nhật lại nội dung đã thay thế URL ảnh
            $data['content'] = $content;

            if ($request->hasFile('image')) {
                $imagePath = Storage::put(self::PATH_UPLOAD, $request->file('image'));
                $data['image'] = $imagePath;
            }

            // Lưu bài viết
            $newPost = Post::create($data);

            if ($request->filled('tags')) {
                $tags = array_map('trim', explode(',', $request->input('tags')));
                foreach ($tags as $tagName) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $newPost->tags()->attach($tag);
                }
            }

            // Kiểm tra bài viết đã được lưu hay chưa
            if (!$newPost) {
                throw new \Exception('Thêm mới thất bại!');
            }

            DB::commit();

            return redirect()->route('admin.posts.index')->with(['success' => 'Thêm mới thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi thêm bài viết: ' . $e->getMessage() . ' - Dòng lỗi: ' . $e->getLine());
            return redirect()->back()->withInput()->with(['error' => 'Thêm mới thất bại! Lỗi: ' . $e->getMessage()]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        // Tăng view lên 1
        $post->increment('view');

        return view(self::PATH_VIEW . __FUNCTION__, compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa bài viết';

        $post = Post::withTrashed()->findOrFail($id); // Lấy bài viết kể cả bài viết đã bị soft delete

        // Lấy tất cả các danh mục, bao gồm cả danh mục đã bị xóa mềm
        $categories = Category::withTrashed()->get();

        // Xây dựng cây danh mục
        $categoryTree = Category::buildCategoryTree($categories, null, true); // Tham số true để bỏ qua các danh mục cha bị xóa mềm

        // Lấy danh sách các tag
        $tags = $post->tags->pluck('name')->implode(',');

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'post', 'categoryTree', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $post = Post::withTrashed()->findOrFail($id);

            $data = $request->except('image');
            $data['user_id'] = Auth::user()->id;
            $data['is_active'] = $data['is_active'] ?? 0;

            // Nội dung cũ của bài viết trước khi chỉnh sửa
            $oldContent = $post->content;

            // Nội dung mới của bài viết sau khi chỉnh sửa
            $newContent = $data['content'];

            // Tìm tất cả các URL ảnh trong nội dung cũ và nội dung mới
            preg_match_all('/src="([^"]*)"/', $oldContent, $oldMatches);
            preg_match_all('/src="([^"]*)"/', $newContent, $newMatches);

            $oldImagePaths = $oldMatches[1]; // Ảnh trong nội dung cũ
            $newImagePaths = $newMatches[1]; // Ảnh trong nội dung mới

            // Xóa các ảnh không còn trong nội dung mới
            foreach ($oldImagePaths as $oldImageUrl) {
                if (!in_array($oldImageUrl, $newImagePaths)) {
                    // Loại bỏ phần asset URL để lấy đường dẫn thực tế của ảnh
                    $oldImagePath = str_replace(asset('storage/'), '', $oldImageUrl);

                    // Kiểm tra và xóa file ảnh nếu tồn tại
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
            }

            // Di chuyển các ảnh mới từ thư mục tạm sang thư mục uploads
            preg_match_all('/src="([^"]*)"/', $newContent, $matches);
            $imagePaths = $matches[1]; // Mảng chứa URL các ảnh tạm

            foreach ($imagePaths as $tmpImageUrl) {
                $tmpImagePath = str_replace(asset('storage/tmp_uploads/'), '', $tmpImageUrl);
                $newImagePath = 'uploads/' . basename($tmpImagePath);

                // Kiểm tra sự tồn tại của ảnh tạm và di chuyển
                if (Storage::disk('public')->exists('tmp_uploads/' . $tmpImagePath)) {
                    Storage::disk('public')->move('tmp_uploads/' . $tmpImagePath, $newImagePath);

                    // Thay thế URL tạm bằng URL mới trong nội dung
                    $newContent = str_replace($tmpImageUrl, asset('storage/' . $newImagePath), $newContent);
                }
            }

            // Cập nhật lại nội dung đã thay thế URL ảnh
            $data['content'] = $newContent;

            // Xử lý ảnh đại diện
            if ($request->hasFile('image')) {
                if ($post->image && Storage::disk('public')->exists($post->image)) {
                    Storage::disk('public')->delete($post->image);
                }
                $imagePath = Storage::put(self::PATH_UPLOAD, $request->file('image'));
                $data['image'] = $imagePath;
            }

            // Cập nhật bài viết
            $post->update($data);

            // Cập nhật tag mới và xóa tag cũ
            $post->tags()->sync([]); // Xóa tất cả các tag cũ
            if ($request->filled('tags')) {
                $tags = array_map('trim', explode(',', $request->input('tags')));
                foreach ($tags as $tagName) {
                    // Tạo hoặc tìm tag theo tên
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    // Gán tag cho bài viết
                    $post->tags()->attach($tag);
                }
            }

            // Sau khi cập nhật, xóa các tag không còn được gắn với bất kỳ bài viết nào
            $this->deleteUnusedTags();

            DB::commit();
            return redirect()->route('admin.posts.index')->with(['success' => 'Cập nhật bài viết thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật bài viết: ' . $e->getMessage() . ' - Dòng lỗi: ' . $e->getLine());
            return redirect()->back()->withInput()->with(['error' => 'Cập nhật thất bại! Lỗi: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return back()->with(['success' => 'Xóa thành công']);
    }

    public function restore(string $id)
    {
        // Tìm bài viết đã bị xóa mềm và khôi phục nó
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts.index')->with(['success' => 'Khôi phục bài viết thành công!']);
    }

    public function forceDelete(string $id)
    {
        // Tìm bài viết đã bị soft delete
        $post = Post::onlyTrashed()->findOrFail($id);

        // Nếu bài viết không tồn tại
        if (!$post) {
            return redirect()->route('admin.posts.index')->with(['error' => 'Bài viết không tồn tại!']);
        }

        // Xóa ảnh đại diện nếu ảnh tồn tại
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Tìm tất cả các ảnh trong nội dung bài viết và xóa
        $content = $post->content;
        preg_match_all('/<img[^>]+src="([^">]+)"/', $content, $matches);
        $imageUrls = $matches[1]; // Mảng chứa các URL ảnh trong content

        foreach ($imageUrls as $imageUrl) {
            // Kiểm tra xem ảnh có nằm trong thư mục uploads không
            if (strpos($imageUrl, asset('storage/uploads')) !== false) {
                // Loại bỏ phần asset để lấy đường dẫn file ảnh thực tế
                $imagePath = str_replace(asset('storage/'), '', $imageUrl);

                // Kiểm tra và xóa file ảnh nếu tồn tại trong thư mục uploads
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        // Lưu lại các tag liên kết với bài viết
        $tags = $post->tags;

        // Xóa các tag liên kết với bài viết khỏi bảng trung gian
        $post->tags()->detach();

        // Xóa vĩnh viễn bài viết ra khỏi hệ thống
        $post->forceDelete();

        // Sau khi cập nhật, xóa các tag không còn được gắn với bất kỳ bài viết nào
        $this->deleteUnusedTags();

        return redirect()->route('admin.posts.trash')->with(['success' => 'Xoá bài viết, các tag liên quan và các ảnh trong nội dung thành công!']);
    }

    private function deleteUnusedTags()
    {
        $tags = Tag::all();

        foreach ($tags as $tag) {
            // Nếu tag không còn được liên kết với bất kỳ bài viết nào, thì xóa tag
            if ($tag->posts()->count() === 0) {
                $tag->delete();
            }
        }
    }
}
