<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Lấy danh sách người dùng
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Thêm quản trị "người đăng bài"
    public function promoteToPoster($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->type = 'admin'; // giả sử role được dùng để phân quyền
            $user->save();
            return response()->json(['message' => 'User promoted to poster successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->update($request->all());
            return response()->json(['message' => 'User updated successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }


    //tìm kiếm người dùng theo từ khóa (tên, email), vai trò (role), và thời gian đăng ký (created_at)
    public function search(Request $request)
    {
        // Khởi tạo query cho bảng User
        $query = User::query();

        // Tìm kiếm theo từ khóa: Tìm theo tên hoặc email
        if ($request->has('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        // Tìm kiếm theo vai trò (role)
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        // Tìm kiếm theo khoảng thời gian tạo người dùng
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Thực thi và lấy kết quả tìm kiếm
        $users = $query->get();

        // Trả về kết quả dưới dạng JSON
        return response()->json($users);
    }

}
