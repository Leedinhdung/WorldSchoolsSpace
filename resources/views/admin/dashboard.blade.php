@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>

        <div class="row">
            @php
                $cards = [
                    [
                        'title' => 'Người dùng',
                        'count' => $userCount,
                        'data' => [
                            'Mới hôm nay' => $newUsersToday,
                            'Mới trong tuần này' => $usersThisWeek,
                            'Mới trong tháng này' => $usersThisMonth,
                            'Mới trong năm này' => $usersThisYear,
                        ],
                    ],
                    [
                        'title' => 'Bài viết',
                        'count' => $postCount,
                        'data' => [
                            'Mới hôm nay' => $postsToday,
                            'Mới trong tuần này' => $postsThisWeek,
                            'Mới trong tháng này' => $postsThisMonth,
                            'Mới trong năm này' => $postsThisYear,
                        ],
                    ],
                    [
                        'title' => 'Bình luận',
                        'count' => $commentCount,
                        'data' => [
                            'Mới hôm nay' => $commentsToday,
                            'Mới trong tuần này' => $commentsThisWeek,
                            'Mới trong tháng này' => $commentsThisMonth,
                            'Mới trong năm này' => $commentsThisYear,
                        ],
                    ],
                    [
                        'title' => 'Truy cập',
                        'count' => $totalViews,
                        'data' => [
                            'Mới hôm nay' => $dailyVisits,
                            'Mới trong tuần này' => $weeklyVisits,
                            'Mới trong tháng này' => $monthlyVisits,
                            'Mới trong năm này' => $yearlyVisits,
                        ],
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1">{{ $card['title'] }}</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Tổng: </strong> {{ $card['count'] }}</p>
                            @foreach ($card['data'] as $label => $value)
                                <p><strong>{{ $label }}: </strong> {{ $value }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h2>Dữ liệu hàng tháng</h2>
        <div class="row">
            <!-- Biểu đồ New Users by Month -->
            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">Người dùng mới theo tháng</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a href="#" class="text-reset dropdown-btn" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted">Report <i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Download Report</a>
                                    <a class="dropdown-item" href="#">Export</a>
                                    <a class="dropdown-item" href="#">Import</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="newUsersChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ Visits by Month -->
            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">Lượt truy cập theo tháng</h4>
                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a href="#" class="text-reset dropdown-btn" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted">Report <i class="mdi mdi-chevron-down ms-1"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Download Report</a>
                                    <a class="dropdown-item" href="#">Export</a>
                                    <a class="dropdown-item" href="#">Import</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="visitsChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ New Posts by Month -->
            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">Bài viết mới theo tháng</h4>
                    </div>
                    <div class="card-body">
                        <div id="newPostsChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ Comments by Month -->
            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">Bình luận theo tháng</h4>
                    </div>
                    <div class="card-body">
                        <div id="commentsChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-libs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.28.3/apexcharts.min.js"></script>

    <script>
        // Truyền dữ liệu từ Blade View vào JavaScript
        var newUsersData = @json(array_values($newUsersData));
        var visitsData = @json(array_values($visitsData));
        var newPostsData = @json(array_values($newPostsData));
        var commentsData = @json(array_values($commentsData));

        console.log('New Users Data:', newUsersData);
        console.log('Visits Data:', visitsData);
        console.log('New Posts Data:', newPostsData);
        console.log('Comments Data:', commentsData);

        function createApexChart(chartId, title, data) {
            if (document.querySelector(`#${chartId}`) === null) {
                console.warn(`Element with ID ${chartId} not found.`);
                return;
            }

            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: title,
                    data: data
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                colors: ['#75c3c0'],
                stroke: {
                    width: 3
                },
                fill: {
                    opacity: 0.3
                }
            };

            var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
            chart.render();
        }


        document.addEventListener('DOMContentLoaded', function() {
            createApexChart('newUsersChart', 'New Users', newUsersData);
            createApexChart('visitsChart', 'Visits', visitsData);
            createApexChart('newPostsChart', 'New Posts', newPostsData);
            createApexChart('commentsChart', 'Comments', commentsData);
        })
    </script>

    <script src="{{ asset('theme/admin/assets/js/layout.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection
