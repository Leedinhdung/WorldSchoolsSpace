<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryStoreRequest;
use App\Http\Requests\Admin\Category\CategoryUpdateRequest;
use App\Models\Category;
use Auth;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.categories.';
    const PATH_UPLOAD = 'categories';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Danh sách danh mục';
        $categories = Category::whereNull('deleted_at')->get();
        $totalCategories = Category::whereNull('deleted_at')->count();
        $trashedCategories = Category::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'categories', 'totalCategories', 'trashedCategories'));
    }

    public function trash()
    {
        $title = 'Thùng rác';
        $trashedCategories = Category::onlyTrashed()->get();
        $totalTrashedCategories = Category::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'trashedCategories', 'totalTrashedCategories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm danh mục';
        // Lấy tất cả danh mục và xây dựng cây
        $categories = Category::whereNull('deleted_at')->get();
        $categoryTree = Category::buildCategoryTree($categories);

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'categoryTree'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        //Bắt đầu transaction
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['is_active'] ??= 0;
            $data['parent_id'] ??= 0;
            // dd($data);
            $newCategory = Category::create($data);

            // Nếu không tạo được Category thì throw lỗi
            if (!$newCategory) {
                throw new \Exception('Thêm mới thất bại!');
            }

            // Lưu lại transaction
            DB::commit();

            // Điều hướng và thông báo thành công
            return redirect()->route('admin.categories.index')->with(['success' => 'Thêm mới thành công!']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            // Điều hướng và thông báo lỗi
            return redirect()->route('admin.categories.index')->with(['error' => 'Thêm mới thất bại!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa danh mục';

        // Tìm danh mục cần sửa
        $getCategoryById = Category::findOrFail($id);

        // Lấy tất cả các danh mục cha khác để chọn làm danh mục cha cho danh mục này
        $categories = Category::whereNull('deleted_at')->where('id', '!=', $id)->get();
        $categoryTree = Category::buildCategoryTree($categories);

        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'getCategoryById', 'categoryTree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        // Tìm danh mục cần sửa
        $category = Category::findOrFail($id);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['is_active'] = $data['is_active'] ?? 0;
            $data['parent_id'] = $data['parent_id'] ?? 0;
            // dd($data);

            $category->update($data);

            // Lưu lại transaction
            DB::commit();

            // Điều hướng và thông báo thành công
            return redirect()->route('admin.categories.index')->with(['success' => 'Cập nhật thành công!']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            // Điều hướng và thông báo lỗi
            return redirect()->route('admin.categories.index')->with(['error' => 'Cập nhật thất bại!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with(['success' => 'Xóa thành công']);
    }

    public function forceDelete(string $id)
    {
        // Lấy danh mục cha đã bị soft delete
        $category = Category::onlyTrashed()->findOrFail($id);

        // Kiểm tra xem danh mục có tồn tại hay không
        if (!$category) {
            return redirect()->route('admin.categories.index')->with(['error' => 'Danh mục không tồn tại!']);
        }

        // Lấy tất cả các danh mục con của danh mục này, bao gồm cả những danh mục con đã bị xóa mềm
        $childrenCategories = Category::withTrashed()->where('parent_id', $category->id)->get();

        // Cập nhật tất cả danh mục con, chuyển chúng thành danh mục cha (parent_id = 0)
        foreach ($childrenCategories as $childCategory) {
            // Chỉ cập nhật parent_id, không khôi phục danh mục đã bị xóa mềm
            $childCategory->parent_id = 0;
            $childCategory->save();
        }

        //Xoá vĩnh viễn bản ghi ra khỏi hệ thống
        $category->forceDelete();

        return redirect()->route('admin.categories.trash')->with(['success' => 'Xoá thành công']);
    }

    public function restore(string $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if (!$category) {
            return redirect()->route('admin.categories.index')->with(['error' => 'Danh mục không tồn tại']);
        }
        $category->restore();
        return redirect()->route('admin.categories.index')->with(['success' => 'Khôi phục thành công!']);
    }
}
