@extends('Admin.layouts.master')
@section('title')
    Chỉnh sửa người dùng | Velzon
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới người dùng</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý người dùng</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Cập nhât thông tin</h4>
        </div><!-- end card header -->
        <div class="card-body">
            <form action="{{ route('admin.user.update', $user->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="text-center pt-3 pb-4 mb-1">
                    <h5>Cập nhật tài khoản của bạn</h5>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel"
                        aria-labelledby="pills-gen-info-tab">
                        <div>
                            <div class="mb-4">
                                <div>
                                    <h5 class="mb-1">Thông tin chung</h5>
                                    <p class="text-muted">Điền đầy đủ các thông tin dưới đây</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="gen-info-first-name-input">Họ</label>
                                        <input type="text" class="form-control" name="first_name"
                                            id="gen-info-first-name-input" placeholder="Nhập họ" value="{{ $user->name }}"
                                            required>
                                        <div class="invalid-feedback">Vui lòng nhập họ của bạn</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="gen-info-email-input">Email</label>
                                        <input type="email" class="form-control" name="email" id="gen-info-email-input"
                                            placeholder="Nhập email" value="{{ $user->email }}" required>
                                        <div class="invalid-feedback">Vui lòng nhập địa chỉ email</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="gen-info-email-input">Vai trò</label>
                                        <select class="js-example-basic-multiple" name="role_id[]" multiple="multiple"
                                            required>
                                            @foreach ($role as $value)
                                                <option {{ in_array($value->id, $roleOfUser) ? 'selected' : '' }}
                                                    value="{{ $value->id }}">{{ $value->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        <div class="invalid-feedback">Vui lòng chọn vai trò</div>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button class="btn btn-success">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                    <!-- end tab pane -->
                </div>
            </form>
        </div>
    </div>
@endsection
@section('style-libs')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('script-libs')
    <!-- ckeditor -->
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/js/pages/select2.init.js') }}"></script>
    <script>
        $(".js-example-basic-multiple").select2({
            placeholder: "Select a state",
            allowClear: true
        });
    </script>
@endsection
