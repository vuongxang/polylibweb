<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdfFileRequest extends FormRequest
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
            'pdf_file' => "required|mimes:pdf|max:30000"
        ];
    }

    public function messages()
    {
        return [
            'pdf_file.required' => 'Vui lòng upload file.',
            'pdf_file.mimes' => 'Vui lòng nhập file pdf.',
            'pdf_file.max' => 'File quá lớn.',
        ];
    }
}
