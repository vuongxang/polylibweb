<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostShareRequest extends FormRequest
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
            'title' => 'required|unique:post_share_categories|min:5',
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png,gif|max:2000',
            'content' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Nhập tiêu đề bài viết',
            'title.unique' => 'Tên bài viết đã tồn tại',
            'title.min' => 'Tối thiểu 5 ký tự',
            'thumbnail.required' => 'Chọn ảnh bài viết',
            'thumbnail.mimes' => 'Không đúng định dạng ảnh',
            'thumbnail.image' => 'File không phải là ảnh',
            'thumbnail.max' => 'Size ảnh không quá 2MB',
            'content.required' => 'Nhập nội dung bài viết',
        ];
    }
}
