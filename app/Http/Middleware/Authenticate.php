<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Nếu yêu cầu là từ API, trả về lỗi 401 Unauthorized thay vì chuyển hướng
        if ($request->expectsJson()) {
            return null;  // Trả về null để Laravel trả về lỗi 401
        }

        // Đối với ứng dụng web, chuyển hướng đến trang đăng nhập
        return route('login');
    }
}
