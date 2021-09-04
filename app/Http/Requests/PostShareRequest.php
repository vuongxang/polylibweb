<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => ['required','min:5',Rule::unique('post_shares')->ignore($this->id)],
            'cate_id' => 'required',
            'thumbnail' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2000'],
            'content' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.unique' => 'Tiêu đề bài viết đã tồn tại.',
            'title.required' => 'Nhập tiêu đề bài viết',
            'title.min' => 'Tối thiểu 5 ký tự',
            'cate_id.required' => 'Chọn danh mục bài viết',
            'thumbnail.required' => 'Chọn ảnh bài viết',
            'thumbnail.mimes' => 'Không đúng định dạng ảnh',
            'thumbnail.image' => 'File không phải là ảnh',
            'thumbnail.max' => 'Size ảnh không quá 2MB',
            'content.required' => 'Nhập nội dung bài viết',
        ];
    }
}
