<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelRequest extends FormRequest
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
            'file_upload' => 'required|mimes:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'file_upload.required' => 'Vui lòng tải tệp lên.',
            'file_upload.mimes' => 'Tệp tải lên phải là tệp có định dạng: doc, csv, xlsx, xls, docx, ppt, odt, ods, odp.',
            'file_upload.max' => 'Tệp quá lớn.',
        ];
    }
}
