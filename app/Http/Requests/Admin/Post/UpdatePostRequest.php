<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Lấy ID của bài viết từ request hoặc route
        $postId = $this->route('id'); // Giả sử route của bạn có tham số 'post'

        return [
            'title' => 'required|string|max:255', // Tiêu đề bắt buộc, không được vượt quá 255 ký tự
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif', // Ảnh là tùy chọn, phải là file ảnh hợp lệ
            'tags' => 'distinct', // Các giá trị không được trùng lặp
            'tags.*' => 'exists:tags,id', // Mỗi phần tử của mảng tags phải tồn tại trong bảng tags
            'slug' => [
                'required',
                'string',
                Rule::unique('posts')->ignore($postId), // Slug là bắt buộc và phải là duy nhất, bỏ qua bài viết hiện tại
            ],
            'excerpt' => 'required|string', // Tóm tắt là bắt buộc
            'content' => 'required|string', // Nội dung là bắt buộc
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.string' => 'Tiêu đề phải là một chuỗi',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',

            'image.image' => 'Tệp tải lên phải là hình ảnh',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif',

            'tags.distinct' => 'Các tag không được trùng lặp',
            'tags.*.exists' => 'Tag không hợp lệ',

            'slug.required' => 'Slug là bắt buộc',
            'slug.string' => 'Slug phải là một chuỗi',
            'slug.unique' => 'Slug đã tồn tại', // Thêm điều kiện này để kiểm tra tính duy nhất của slug

            'excerpt.required' => 'Tóm tắt là bắt buộc',
            'excerpt.string' => 'Tóm tắt phải là một chuỗi',

            'content.required' => 'Nội dung là bắt buộc',
            'content.string' => 'Nội dung phải là một chuỗi',
        ];
    }
}
