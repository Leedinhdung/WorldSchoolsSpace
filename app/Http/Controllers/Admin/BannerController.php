<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\BannerStoreRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.banners.';
    const PATH_UPLOAD = 'banners';
    public function index()
    {
        $title = 'Danh sách banner';
        $banners = Banner::whereNull('deleted_at')->get();
        $totalBanners = Banner::whereNull('deleted_at')->count();
        $trashedBanners = Banner::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'banners', 'totalBanners', 'trashedBanners'));
    }

    public function trash()
    {
        $title = 'Thùng rác';
        $trashedBanners = Banner::onlyTrashed()->get();
        $totalTrashedBanners = Banner::onlyTrashed()->count();
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'trashedBanners', 'totalTrashedBanners'));
    }
    public function create()
    {
        $title = 'Thêm banner';
        return view(self::PATH_VIEW . __FUNCTION__, compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(BannerStoreRequest $request)
    {

        //Bắt đầu transaction
        DB::beginTransaction();
        try {
            $data = $request->except('image');
            $data['user_id'] = Auth::user()->id;
            if ($request->hasFile('image')) {
                $imagePath = Storage::put(self::PATH_UPLOAD, $request->file('image'));
                $data['image'] = $imagePath;
            }
            $newBanner = Banner::create($data);

            // Nếu không tạo được banner thì throw lỗi
            if (!$newBanner) {
                throw new \Exception('Thêm mới thất bại!');
            }

            // Lưu lại transaction
            DB::commit();

            // Điều hướng và thông báo thành công
            return redirect()->route('admin.banner.index')->with(['success' => 'Thêm mới thành công!']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            // Xóa ảnh đã upload nếu đã lưu trước đó
            if (!empty($imagePath)) {
                Storage::delete($imagePath);
            }

            // Điều hướng và thông báo lỗi
            return redirect()->route('admin.banner.index')->with(['error' => 'Thêm mới thất bại!']);
        }
    }
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa banner';
        $getBannerById = Banner::findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('title', 'getBannerById'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);
        DB::beginTransaction();
        try {
            $data = $request->except('image');
            $data['is_active'] = $data['is_active'] ?? 0;
            if ($request->hasFile('image')) {
                if (!empty($banner->image) && Storage::exists($banner->image)) {
                    Storage::delete($banner->image);
                }
                $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            }
            $banner->update($data);
            DB::commit();
            return redirect()->route('admin.banner.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($data['image'])) {
                Storage::delete($data['image']);
            }
            return redirect()->route('admin.banner.index')->with('error', 'Cập nhật thất bại!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return back()->with(['success' => 'Xóa thành công']);
    }
    public function restore(string $id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        if (!$banner) {
            return redirect()->route('admin.banner.index')->with(['error' => 'Banner không tồn tại']);
        }
        $banner->restore();
        return redirect()->route('admin.banner.index')->with(['success' => 'Khôi phục thành công!']);
    }
    public function forceDelete(string $id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        if (!$banner) {
            return redirect()->route('admin.banner.index')->with(['error' => 'Banner không tồn tại!']);
        }
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        //Xoá vĩng viễn bản ghi ra khỏi hệ thống
        $banner->forceDelete();
        return redirect()->route('admin.banner.trash')->with(['success' => 'Xoá thành công']);
    }
}
