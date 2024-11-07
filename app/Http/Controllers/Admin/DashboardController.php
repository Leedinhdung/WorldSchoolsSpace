<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng số người dùng, bài viết, bình luận và lượt xem
        $userCount = User::count();
        $postCount = Post::count();
        $commentCount = Comment::count();
        $totalViews = Post::sum('views');

        // Số người dùng mới, bài viết và bình luận trong ngày
        $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
        $postsToday = Post::whereDate('created_at', Carbon::today())->count();
        $commentsToday = Comment::whereDate('created_at', Carbon::today())->count();

        // Tổng số người dùng, bài viết và bình luận trong tuần
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $usersThisWeek = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $postsThisWeek = Post::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $commentsThisWeek = Comment::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        // Tổng số người dùng, bài viết và bình luận trong tháng
        $usersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $postsThisMonth = Post::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $commentsThisMonth = Comment::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Tổng số người dùng, bài viết và bình luận trong năm
        $usersThisYear = User::whereYear('created_at', Carbon::now()->year)->count();
        $postsThisYear = Post::whereYear('created_at', Carbon::now()->year)->count();
        $commentsThisYear = Comment::whereYear('created_at', Carbon::now()->year)->count();

        // Lượt truy cập
        $dailyVisits = Visit::whereDate('visited_at', Carbon::today())->count();
        $weeklyVisits = Visit::whereBetween('visited_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $monthlyVisits = Visit::whereMonth('visited_at', Carbon::now()->month)
            ->whereYear('visited_at', Carbon::now()->year)
            ->count();

        // Tổng lượt truy cập trong năm
        $yearlyVisits = Visit::whereYear('visited_at', Carbon::now()->year)->count();

        // Chuẩn bị dữ liệu cho biểu đồ theo tháng
        $newUsersData = $this->getMonthlyData(User::class, 'created_at');
        $visitsData = $this->getMonthlyData(Visit::class, 'visited_at');
        $newPostsData = $this->getMonthlyData(Post::class, 'created_at');
        $commentsData = $this->getMonthlyData(Comment::class, 'created_at');

        return view('admin.dashboard', compact(
            'userCount',
            'newUsersToday',
            'usersThisMonth',
            'usersThisWeek',
            'usersThisYear',
            'postCount',
            'postsToday',
            'postsThisMonth',
            'postsThisWeek',
            'postsThisYear',
            'totalViews',
            'commentCount',
            'commentsToday',
            'commentsThisMonth',
            'commentsThisWeek',
            'commentsThisYear',
            'dailyVisits',
            'weeklyVisits',
            'monthlyVisits',
            'yearlyVisits',
            'newUsersData',
            'visitsData',
            'newPostsData',
            'commentsData'
        ));
    }

    /**
     * Lấy dữ liệu theo tháng cho một mô hình nhất định
     *
     * @param string $modelClass Tên lớp mô hình
     * @param string $dateColumn Tên cột chứa ngày tháng
     * @return array Mảng chứa số liệu theo tháng
     */
    private function getMonthlyData($modelClass, $dateColumn)
    {
        $data = [];
        $currentYear = Carbon::now()->year;

        // Lặp qua từng tháng trong năm
        for ($month = 1; $month <= 12; $month++) {
            // Lọc dữ liệu theo tháng và năm
            $data[$month] = $modelClass::whereMonth($dateColumn, $month)
                ->whereYear($dateColumn, $currentYear)
                ->count();
        }

        return $data;
    }
}
