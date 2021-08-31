<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            "topic" => 'required|min:5|max:250',
            "name" => 'required|min:5|max:30',
            "email" => ['required','email','regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@fpt\.edu\.vn$/ix'],
            "phone" => ['required','regex:/(03|09)[0-9]{8}/','size:10'],
            "content" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'topic.required' => 'Nhập chủ đề',
            'topic.min' => 'Tối thiểu 5 ký tự',
            'topic.max' => 'Không được vượt quá 250 ký tự',
            'name.required' => 'Nhập họ và tên',
            'name.min' => 'Tối thiểu 5 ký tự',
            'name.max' => 'Không được vượt quá 30 ký tự',
            'email.required' => 'Nhập email',
            'email.regex' => 'Sử dụng mail @fpt.edu.vn',
            'phone.required' => 'Nhập số điện thoại',
            'phone.regex' => 'Sử dụng số điện thoại đầu 03 hoặc 09',
            'phone.size' => 'Nhập tối đa 10 số',
            'content.required' => 'Nhập nội dung'
        ];
    }
}
