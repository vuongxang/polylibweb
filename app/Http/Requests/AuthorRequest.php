<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'name' => 'required|unique:categories|min:5|max:30',
            'avatar' => 'required',
            'description' => 'required|max:255',
            'date_birth' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên tác giả',
            'name.unique' => 'Tác giả đã tồn tại',
            'name.min' => 'Tối thiểu 5 ký tự',
            'name.max' => 'Không được vượt quá 30 ký tự',
            'avatar.required' => 'Thêm ảnh tác giả',
            'description.max' => 'Không được vượt quá 255 ký tự',
            'description.required' => 'Nhập mô tả',
            'date_birth.required' => 'Nhập ngày sinh',
        ];
    }
}
