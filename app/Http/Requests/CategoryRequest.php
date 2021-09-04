<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            "name" => ['required','min:5','max:30',Rule::unique('categories')->ignore($this->id)],
            "image" => ['required','regex:([^\\s]+(\\.(?i)(jpe?g|jpg|png|gif))$)'],
            "description" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên danh mục sách',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'name.min' => 'Tối thiểu 5 ký tự',
            'name.max' => 'Không được vượt quá 30 ký tự',
            'image.required' => 'Chọn ảnh danh mục sách',
            'image.regex' => 'Không đúng định dạng ảnh',
            'image.size' => 'Anhrrrrr',
            // 'description.max' => 'Không được vượt quá 255 ký tự',
            'description.required' => 'Nhập thông tin giới thiệu danh mục sách',
        ];
    }
}
