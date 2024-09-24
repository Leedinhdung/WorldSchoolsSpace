@extends('admin.layouts.master')
@section('title')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Create Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Create Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8 ">
                                <label class="form-label" for="product-title-input">Product Title</label>
                                <input type="hidden" class="form-control" id="formAction" name="formAction" value="add">
                                <input type="text" class="form-control d-none" id="product-id-input">
                                <input type="text" class="form-control" id="product-title-input" value=""
                                    placeholder="Enter product title" required>
                                <div class="invalid-feedback">Please Enter a product title.</div>
                            </div>
                            <div class="col-4">
                                <label for="">Danh mục</label>
                                <select class="form-select" id="choices-category-input" name="choices-category-input"
                                    data-choices data-choices-search-false>
                                    <option value="Appliances">Appliances</option>
                                    <option value="Automotive Accessories">Automotive Accessories</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Fashion">Fashion</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Grocery">Grocery</option>
                                    <option value="Kids">Kids</option>
                                    <option value="Watches">Watches</option>
                                </select>

                                <!-- end card body -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Tóm tắt</label>
                            <textarea name="excerpt" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                        <div>
                            <label>Product Description</label>

                            <div id="ckeditor-classic">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->


                <!-- end card -->


                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Đăng</button>
                </div>
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Trạng thái</h5>
                        <label class="switch">
                            <input {{ old('is_active') == 1 ? 'checked' : '' }} name="is_active" id="is_active"
                                value="1" type="checkbox">
                            <div class="slider">
                                <div class="circle">
                                    <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512"
                                        viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path data-original="#000000" fill="currentColor"
                                                d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0">
                                            </path>
                                        </g>
                                    </svg>
                                    <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512"
                                        viewBox="0 0 24 24" y="0" x="0" height="10" width="10"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <path class="" data-original="#000000" fill="currentColor"
                                                d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </label>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Gallery</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <p class="text-muted">Add Product Gallery Images.</p>
                            <div class="dropzone">
                                <div class="fallback">
                                    <input name="file" type="file">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-2 text-muted ri-upload-cloud-2-fill"></i>
                                    </div>
                                    <h5>Tải ảnh lên</h5>
                                </div>
                            </div>

                            <ul class="list-unstyled mb-0" id="dropzone-preview">
                                <li class="mt-2" id="dropzone-preview-list">
                                    <!-- This is used as the file preview template -->
                                    <div class="border rounded">
                                        <div class="d-flex p-2">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm bg-light rounded">
                                                    <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                        src="#" alt="Product-Image" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="pt-1">
                                                    <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                    <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-3">
                                                <button data-dz-remove class="btn btn-sm btn-danger">Xóa</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- end dropzon-preview -->
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="hstack gap-3 align-items-start">
                            <div class="flex-grow-1">
                                <input class="form-control" data-choices data-choices-multiple-remove="true"
                                    placeholder="Enter tags" type="text" value="Cotton" />
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </form>
@endsection
@section('style-libs')
    <link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .switch {
            /* switch */
            --switch-width: 46px;
            --switch-height: 24px;
            --switch-bg: rgb(131, 131, 131);
            --switch-checked-bg: rgb(0, 218, 80);
            --switch-offset: calc((var(--switch-height) - var(--circle-diameter)) / 2);
            --switch-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
            /* circle */
            --circle-diameter: 18px;
            --circle-bg: #fff;
            --circle-shadow: 1px 1px 2px rgba(146, 146, 146, 0.45);
            --circle-checked-shadow: -1px 1px 2px rgba(163, 163, 163, 0.45);
            --circle-transition: var(--switch-transition);
            /* icon */
            --icon-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
            --icon-cross-color: var(--switch-bg);
            --icon-cross-size: 6px;
            --icon-checkmark-color: var(--switch-checked-bg);
            --icon-checkmark-size: 10px;
            /* effect line */
            --effect-width: calc(var(--circle-diameter) / 2);
            --effect-height: calc(var(--effect-width) / 2 - 1px);
            --effect-bg: var(--circle-bg);
            --effect-border-radius: 1px;
            --effect-transition: all .2s ease-in-out;
        }

        .switch input {
            display: none;
        }

        .switch {
            display: inline-block;
        }

        .switch svg {
            -webkit-transition: var(--icon-transition);
            -o-transition: var(--icon-transition);
            transition: var(--icon-transition);
            position: absolute;
            height: auto;
        }

        .switch .checkmark {
            width: var(--icon-checkmark-size);
            color: var(--icon-checkmark-color);
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
        }

        .switch .cross {
            width: var(--icon-cross-size);
            color: var(--icon-cross-color);
        }

        .slider {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            width: var(--switch-width);
            height: var(--switch-height);
            background: var(--switch-bg);
            border-radius: 999px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            -webkit-transition: var(--switch-transition);
            -o-transition: var(--switch-transition);
            transition: var(--switch-transition);
            cursor: pointer;
        }

        .circle {
            width: var(--circle-diameter);
            height: var(--circle-diameter);
            background: var(--circle-bg);
            border-radius: inherit;
            -webkit-box-shadow: var(--circle-shadow);
            box-shadow: var(--circle-shadow);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-transition: var(--circle-transition);
            -o-transition: var(--circle-transition);
            transition: var(--circle-transition);
            z-index: 1;
            position: absolute;
            left: var(--switch-offset);
        }

        .slider::before {
            content: "";
            position: absolute;
            width: var(--effect-width);
            height: var(--effect-height);
            left: calc(var(--switch-offset) + (var(--effect-width) / 2));
            background: var(--effect-bg);
            border-radius: var(--effect-border-radius);
            -webkit-transition: var(--effect-transition);
            -o-transition: var(--effect-transition);
            transition: var(--effect-transition);
        }

        /* actions */

        .switch input:checked+.slider {
            background: var(--switch-checked-bg);
        }

        .switch input:checked+.slider .checkmark {
            -webkit-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }

        .switch input:checked+.slider .cross {
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            transform: scale(0);
        }

        .switch input:checked+.slider::before {
            left: calc(100% - var(--effect-width) - (var(--effect-width) / 2) - var(--switch-offset));
        }

        .switch input:checked+.slider .circle {
            left: calc(100% - var(--circle-diameter) - var(--switch-offset));
            -webkit-box-shadow: var(--circle-checked-shadow);
            box-shadow: var(--circle-checked-shadow);
        }
    </style>
@endsection
@section('script-libs')
    <!-- ckeditor -->
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- dropzone js -->
    <script src="{{ asset('theme/admin/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>
@endsection
