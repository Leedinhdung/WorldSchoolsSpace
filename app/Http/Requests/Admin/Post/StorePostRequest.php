<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255', // Trường title không được trống, là chuỗi và tối đa 255 ký tự
            'image' => 'required|image|mimes:jpg,jpeg,png,gif', // Trường image bắt buộc, phải là file ảnh (jpg, jpeg, png, gif)
            'tags' => 'distinct', // các giá trị không được trùng lặp
            'tags.*' => 'exists:tags,id', // Mỗi phần tử của mảng tags phải tồn tại trong bảng tags (cột id)
            'slug' => 'required|string', // Trường slug là bắt buộc
            'excerpt' => 'required|string', // Trường excerpt là bắt buộc
            'content' => 'required|string', // Trường content là bắt buộc
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.string' => 'Tiêu đề phải là một chuỗi',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',

            'image.required' => 'Ảnh là bắt buộc',
            'image.image' => 'Tệp tải lên phải là hình ảnh',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif',

            'tags.distinct' => 'Các tag không được trùng lặp',
            'tags.*.exists' => 'Tag không hợp lệ',

            'slug.required' => 'Slug là bắt buộc',
            'slug.string' => 'Slug phải là một chuỗi',

            'excerpt.required' => 'Tóm tắt là bắt buộc',
            'excerpt.string' => 'Tóm tắt phải là một chuỗi',

            'content.required' => 'Nội dung là bắt buộc',
            'content.string' => 'Nội dung phải là một chuỗi',
        ];
    }

}
