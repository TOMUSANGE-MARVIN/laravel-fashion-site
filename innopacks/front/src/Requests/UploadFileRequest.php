<?php
/* */

namespace InnoShop\Front\Requests;

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
        if (is_admin()) {
            $rule = 'required|image|mimes:jpg,png,jpeg,gif,svg,webp,zip,doc,docx,xls,xlsx,ppt,pptx,pdf,mp4|max:4096';
        } else {
            $rule = 'required|image|mimes:jpg,png,jpeg,gif,webp,zip,doc,docx,xls,xlsx,ppt,pptx,pdf,mp4|max:2048';
        }

        return [
            'file' => $rule,
            'type' => 'required|alpha_dash',
        ];
    }
}
