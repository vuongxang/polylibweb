<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostShareCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:post_share_categories|min:5',
            'image' => ['required','regex:([^\\s]+(\\.(?i)(jpe?g|jpg|png))$)', 'max:100'],
            'description' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nhập tên danh mục bài viết',
            'name.unique' => 'Tên danh mục bài viết đã tồn tại',
            'name.min' => 'Tối thiểu 5 ký tự',
            'image.required' => 'Chọn ảnh danh mục bài viết',
            'image.regex' => 'Không đúng định dạng ảnh',
            'description.required' => 'Nhập mô tả danh mục bài viết',
        ];
    }
}
