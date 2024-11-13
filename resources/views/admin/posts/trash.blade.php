@extends('admin.layouts.master')
@section('title')
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bài viết</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
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
                            <span>Tất cả ({{ $totalTrashedPosts }})</span>
                        </div>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Quay lại</a>
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
                                <th data-ordering="false">Danh mục</th>
                                <th data-ordering="false">Tiêu đề</th>
                                <th data-ordering="false">Ảnh đại diện</th>
                                <th>Lượt xem</th>
                                <th>Trạng thái</th>
                                <th>Is_active</th>
                                <th>Thao tác</th>
                                <th>Tóm tắt</th>
                                <th>Nội dung</th>
                                <th>Đường dẫn</th>
                                <th>Người viết</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <th scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" name="checkAll"
                                            value="option1">
                                    </div>
                                </th>
                                <td>01</td>
                                <td>VLZ-452</td>
                                <td>VLZ1400087402</td>
                                <td><a href="#!">Post launch reminder/ post list</a></td>
                                <td>Joseph Parker</td>
                                <td>Alexis Clarke</td>
                                <td>Joseph Parker</td>
                                <td>03 Oct, 2021</td>
                                <td><span class="badge bg-info-subtle text-info">Re-open</span></td>
                                <td><span class="badge bg-danger">High</span></td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="#!" class="dropdown-item"><i
                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                    View</a></li>
                                            <li><a class="dropdown-item edit-item-btn"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit</a></li>
                                            <li>
                                                <a class="dropdown-item remove-item-btn">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr> --}}

                            @php
                                $i = 0;
                            @endphp
                            @foreach ($trashedPosts as $post)
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
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>
                                        <img src="{{ Storage::url($post->image) }}" alt="..." style="width: 100px;">
                                    </td>
                                    <td>{{ $post->views }}</td>
                                    <td>
                                        {!! $post->status
                                            ? '<span class="badge bg-warning">Chờ duyệt</span>'
                                            : '<span class="badge bg-info">Đã đăng</span>' !!}
                                    </td>
                                    <td>
                                        {!! $post->is_active
                                            ? '<span class="badge bg-primary">Hoạt động</span>'
                                            : '<span class="badge bg-danger">không hoạt động</span>' !!}
                                    </td>
                                    <td>
                                        <div class="">
                                            <a href="{{ route('admin.posts.restore', $post->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục {{ $post->title }} không?')"
                                                class="btn btn-sm btn-warning">Khôi phục</a>
                                            <a href="{{ route('admin.posts.forcedelete', $post->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa {{ $post->title }} không?')"
                                                class="btn btn-sm btn-danger">Xóa</a>
                                        </div>
                                    </td>
                                    <td>{{ $post->excerpt }}</td>
                                    <td>{!! $post->content !!}</td>
                                    <td>{{ $post->slug }}</td>
                                    <td>{{ $post->user->name }}</td>
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
