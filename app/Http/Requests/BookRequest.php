<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|unique:categories|min:5|max:50',
            'image' => 'required',
            'list_image' => 'required',
            'description' => 'required|max:255',
            'publish_date_from' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nhập tên sách',
            'title.unique' => 'Tên sách đã tồn tại',
            'title.min' => 'Tối thiểu 5 ký tự',
            'title.max' => 'Không được vượt quá 50 ký tự',
            'image.required' => 'Chọn ảnh bìa',
            'list_image.required' => 'Thêm nội dung sách',
            'description.max' => 'Không được vượt quá 255 ký tự',
            'description.required' => 'Nhập thông tin chi tiết',
            'publish_date_from.required' => 'Nhập ngày đăng',
        ];
    }
}
