<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.users.';
    const PATH_UPLOAD = 'users';
    public function index()
    {
        $data = User::all();
        // dd($data);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roleOfUser = $user->roles->pluck('id')->toArray();
        $role = Role::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('user', 'role', 'roleOfUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        try {
            // Tìm người dùng theo ID
            $user = User::findOrFail($id);
            $user->roles()->sync($request->role_id); // Giả sử bạn gửi `role_id` từ form

            // Cập nhật dữ liệu người dùng
            $user->update($request->all());

            // Chuyển hướng và hiển thị thông báo thành công
            return redirect()->route('admin.user.index')->with('success', 'Quyền của người dùng đã được cập nhật.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Xử lý nếu không tìm thấy người dùng
            return redirect()->route('admin.user.index')->with('error', 'Không tìm thấy người dùng.');
        } catch (\Exception $e) {
            // Xử lý lỗi khác
            return redirect()->route('admin.user.index')->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
