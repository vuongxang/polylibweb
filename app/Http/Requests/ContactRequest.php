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
        return false;
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
            "image" => ['required','regex:([^\\s]+(\\.(?i)(jpe?g|jpg|png))$)'],
            "description" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'topic.required' => 'Nhập tên danh mục sách',
            'topic.min' => 'Tối thiểu 5 ký tự',
            'topic.max' => 'Không được vượt quá 250 ký tự',
            'image.required' => 'Chọn ảnh danh mục sách',
            'image.regex' => 'Không đúng định dạng ảnh',
            'image.size' => 'Anhrrrrr',
            // 'description.max' => 'Không được vượt quá 255 ký tự',
            'description.required' => 'Nhập thông tin giới thiệu danh mục sách',
        ];
    }
}
