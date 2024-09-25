<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerStoreRequest extends FormRequest
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
            'title' => 'required|max:255',
            'image' => 'required|image|max:5120'
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề cho banner',
            'title.max' => 'Tiêu đề không được quá 255 kí tự',
            'image.required' => 'Vui lòng thêm ảnh',
            'image.image' => 'Không phù hợp, đây không phải là hình ảnh',
            'image.max' => 'Ảnh không được quá 5MB'
        ];
    }
}
