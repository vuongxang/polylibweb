<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255','min:5'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nhập tên.',
            'name.min' => 'Tối thiểu 5 ký tự',
            'name.max' => 'Không được vượt quá 255 ký tự',
            'email.required' => 'Yêu cầu nhập email.',
            'email.email' => 'Yêu cầu nhập đúng định dạng email',
            'email.max' => 'Không được vượt quá 255 ký tự',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Yêu cầu nhập mật khẩu.',
            'password.min' => 'Mật khẩu tổi thiểu 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không chính xác.',
        ];
    }
}
