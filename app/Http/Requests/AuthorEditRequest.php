<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorEditRequest extends FormRequest
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
            'name' => 'required|min:5|max:30',
            'avatar' => ['required','regex:([a-z0-9\+_\-]+(\\.(?i)(jpeg|jpg|png))$)', 'max:100'],
            'description' => 'required',
            'date_birth' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Nhập tên tác giả',
            'name.min' => 'Tối thiểu 5 ký tự',
            'name.max' => 'Không được vượt quá 30 ký tự',
            'avatar.required' => 'Chọn ảnh tác giả',
            'avatar.regex' => 'Không đúng định dạng ảnh',
            'description.required' => 'Nhập thông tin giới thiệu tác giả',
            'date_birth.required' => 'Nhập ngày sinh tác giả',
        ];
    }
}
