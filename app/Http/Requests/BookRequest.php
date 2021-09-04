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
            'title' => 'required|min:5|max:50',
            'image' => ['required','regex:([a-z0-9\+_\-]+(\\.(?i)(jpeg|jpg|png|gif))$)'],
            'description' => 'required',
            'publish_date_from' => 'required',
            'cate_id' => 'required',
            'author_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nhập tên sách',
            'title.min' => 'Tối thiểu 5 ký tự',
            'title.max' => 'Không được vượt quá 50 ký tự',
            'image.required' => 'Chọn ảnh bìa sách',            
            'image.regex' => 'Không đúng định dạng ảnh',
            // 'description.max' => 'Không được vượt quá 255 ký tự',
            'description.required' => 'Nhập thông tin giới thiệu sách',
            'publish_date_from.required' => 'Nhập ngày đăng',
            'cate_id.required' => 'Chọn danh mục',
            'author_id.required' => 'Chọn tác giả',
        ];
    }
}
