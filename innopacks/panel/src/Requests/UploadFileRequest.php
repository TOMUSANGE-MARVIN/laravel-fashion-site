<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:zip,doc,docx,xls,xlsx,ppt,pptx,pdf,jpg,jpeg,png,gif,webp,mp4|max:8192',
            'type' => 'required|alpha_dash',
        ];
    }
}
