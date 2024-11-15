@extends('admin.layouts.master')
@section('title')
    $title
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Banners</a></li>
                        <li class="breadcrumb-item active">Danh sách banner</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between items-content-center">
                        <div>
                            <h5 class="card-title mb-0">Danh sách banner</h5>
                            <div class="d-flex gap-2">
                                <span>Tất cả ({{ $totalBanners }})</span>
                                <div>||</div>
                                <a href="{{ route('admin.banner.trash') }}">Thùng rác ({{ $trashedBanners }})</a>
                            </div>
                        </div>
                        <a href="{{ route('admin.banner.create') }}" class="btn btn-primary">Thêm banner</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th data-ordering="false">STT</th>
                                <th data-ordering="false">Ảnh</th>
                                <th data-ordering="false">Tiêu đề</th>
                                <th data-ordering="false">Trạng thái</th>
                                <th data-ordering="false">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($banners as $banner)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" name="checkAll"
                                                value="option1">
                                        </div>
                                    </th>
                                    <td>{{ $i }}</td>
                                    <td><img src="{{ Storage::url($banner->image) }}" width="100px" class="rounded"
                                            alt=""></td>
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        {!! $banner->is_active
                                            ? '<span class="badge bg-primary">Hoạt động</span>'
                                            : '<span class="badge bg-primary">không hoạt động</span>' !!}
                                    </td>

                                    <td>
                                        <div class="">
                                            <a href="{{ route('admin.banner.edit', $banner->id) }}"
                                                class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                            <a href="{{ route('admin.banner.destroy', $banner->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa {{ $banner->title }} không?')"
                                                class="btn btn-sm btn-danger">Xóa</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection
@section('style-libs')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <!--datatable js-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/datatables.init.js') }}"></script>
@endsection
