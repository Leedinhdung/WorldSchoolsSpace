@extends('admin.layouts.master')
@section('title')
@endsection
@section('content')
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

    <form action="{{ route('admin.posts.store') }}" method="POST" id="createproduct-form" autocomplete="off"
        class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8 ">
                                <label for="title" class="form-label">Tiêu đề bài viết</label>
                                <input type="text" value="{{ old('title') }}" name="title" class="form-control"
                                    placeholder="Nhập tiêu đề" id="title">
                                <small class="help-block form-text text-danger">
                                    @if ($errors->has('title'))
                                        {{ $errors->first('title') }}
                                    @endif
                                </small>
                            </div>
                            <div class="col-4">
                                <label for="category_id">Danh mục</label>
                                <select class="form-select" id="category_id" name="category_id" data-choices
                                    data-choices-search-false>

                                    @foreach ($categoryTree as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @if (!empty($category->children))
                                            @include('admin.categories.option-children', [
                                                'children' => $category->children,
                                                'prefix' => '-',
                                            ])
                                            <hr>
                                        @endif
                                    @endforeach

                                </select>

                                <!-- end card body -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Đường dẫn</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control"
                                placeholder="Đường dẫn thân thiện" readonly id="slug">
                            <small class="help-block form-text text-danger">
                                @if ($errors->has('slug'))
                                    {{ $errors->first('slug') }}
                                @endif
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Tóm tắt</label>
                            <textarea class="form-control" name="excerpt" id="excerpt" cols="30" rows="4">{{ old('excerpt') }}</textarea>
                            <small class="help-block form-text text-danger">
                                @if ($errors->has('excerpt'))
                                    {{ $errors->first('excerpt') }}
                                @endif
                            </small>
                        </div>
                        <div>
                            <div>
                                <label for="content">Nội dung bài viết</label>
                                <textarea id="editor" name="content">{{ old('content') }}</textarea>
                            </div>
                            <small class="help-block form-text text-danger">
                                @if ($errors->has('content'))
                                    {{ $errors->first('content') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                <!-- end card -->


                <!-- end card -->


                <!-- end card -->
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Đăng bài</button>
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
                        <h5 class="card-title mb-0">Ảnh đại diện</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Thêm ảnh đại diện cho bài viết của bạn</p>
                        <input type="file" name="image" id="uploadImage" accept="image/*"
                            onchange="previewImage(event)" class="form-control mb-3">
                        <div id="imagePreview" class="border rounded p-2" style="display:none;">
                            <img id="preview" class="img-fluid rounded" alt="Preview"
                                style="width: 100%; object-fit: cover;">
                            <button type="button" class="btn btn-danger mt-2" onclick="removeImage()">Xóa ảnh</button>
                        </div>
                        <small class="help-block form-text text-danger">
                            @if ($errors->has('image'))
                                {{ $errors->first('image') }}
                            @endif
                        </small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tag của bài viết</h5>
                    </div>
                    <div class="card-body">
                        <div class="hstack gap-3 align-items-start">
                            <div class="flex-grow-1">

                                <div class="tags-input" id="tags-input">
                                    <input type="hidden" id="tags-hidden" name="tags">
                                    <!-- Trường ẩn để lưu các tag -->
                                    <input type="text" id="tags" name="tags-input"
                                        placeholder="Nhập từ khóa...">
                                </div>

                                <div id="tag-list" style="margin-top: 10px;"></div>
                                <!-- Danh sách tag sẽ hiển thị ở đây -->
                                <small class="help-block form-text text-danger">
                                    @if ($errors->has('tags'))
                                        {{ $errors->first('tags') }}
                                    @endif
                                </small>
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
        .tags-input {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            align-items: center;
        }

        .tag {
            background-color: #e0efff;
            /* Màu nền xanh nhạt giống hình */
            color: #333;
            /* Màu chữ */
            padding: 5px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-family: Arial, sans-serif;
            border: 1px solid #add8e6;
            /* Viền nhẹ cho thẻ tag */
        }

        .tag span {
            margin-right: 8px;
            /* Khoảng cách giữa chữ và nút xóa */
        }

        .tag button {
            background: none;
            border: none;
            color: red;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            margin-left: 5px;
        }

        #tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        input#tags {
            border: none;
            outline: none;
            padding: 5px;
            font-size: 14px;
            flex-grow: 1;
            min-width: 100px;
        }

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('tags'); // Trường nhập liệu cho tag
            const hiddenInput = document.getElementById('tags-hidden'); // Trường ẩn để lưu các tag
            const tagList = document.getElementById('tag-list'); // Phần hiển thị danh sách tag
            let tagsArray = hiddenInput.value ? hiddenInput.value.split(',') : []; // Khởi tạo mảng tags

            // Hàm hiển thị các tag từ mảng tagsArray
            function displayTags() {
                tagList.innerHTML = ''; // Xóa các tag hiện có trên giao diện
                tagsArray.forEach(tagText => {
                    const tag = document.createElement('span');
                    tag.classList.add('tag');
                    tag.innerHTML =
                        `<span>${tagText}</span><button type="button" onclick="removeTag('${tagText}')">X</button>`;
                    tagList.appendChild(tag); // Hiển thị tag trong danh sách tag
                });
                updateHiddenInput(); // Cập nhật trường ẩn với các tag
            }

            // Hàm thêm tag
            function addTag(tagText) {
                if (tagText && !tagsArray.includes(tagText)) {
                    tagsArray.push(tagText); // Thêm tag vào mảng tagsArray
                    displayTags(); // Hiển thị lại các tag
                }
                input.value = ''; // Xóa nội dung trong input sau khi thêm tag
            }

            // Sự kiện khi nhấn Enter
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Ngăn submit form khi nhấn Enter
                    const tagText = input.value.trim();
                    addTag(tagText); // Thêm tag vào mảng
                }
            });

            // Sự kiện khi nhấp ra ngoài (blur)
            input.addEventListener('blur', function() {
                const tagText = input.value.trim();
                addTag(tagText); // Thêm tag khi rời khỏi ô nhập
            });

            // Hàm xóa tag
            window.removeTag = function(tagText) {
                tagsArray = tagsArray.filter(tag => tag !== tagText); // Loại bỏ tag khỏi mảng tagsArray
                displayTags(); // Hiển thị lại các tag sau khi xóa
            };

            // Cập nhật giá trị của trường ẩn
            function updateHiddenInput() {
                hiddenInput.value = tagsArray.join(','); // Gán giá trị mảng tag vào trường ẩn
            }

            // Khởi tạo hiển thị các tag nếu đã có
            displayTags();
        });
    </script>


    <script>
        // Hàm hiển thị ảnh khi người dùng chọn file
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('preview');
                    img.src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Hàm xóa ảnh và đặt lại input
        function removeImage() {
            const imgPreview = document.getElementById('imagePreview');
            const inputFile = document.getElementById('uploadImage');
            imgPreview.style.display = 'none';
            inputFile.value = ''; // Đặt lại giá trị của input file
        }
    </script>


    <!-- CKEditor 5 script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "{{ route('admin.posts.ckeditor.upload') . '?_token=' . csrf_token() }}", // Laravel xử lý upload
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>


    {{-- Tự tạo slug --}}
    <script>
        document.getElementById('title').addEventListener('input', function() {
            let nameValue = this.value;

            function removeAccents(str) {
                return str
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/đ/g, 'd')
                    .replace(/Đ/g, 'D');
            }

            let slug = removeAccents(nameValue)
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]+/g, '');

            document.getElementById('slug').value = slug;
        });
    </script>

    <!-- dropzone js -->
    <script src="{{ asset('theme/admin/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>
@endsection
