<?php
/* */

namespace InnoShop\Install\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRequest extends FormRequest
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
            'db_type'        => 'required|string|in:mysql,sqlite',
            'admin_email'    => 'required|email',
            'admin_password' => 'required|string|min:6',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'admin_email'    => trans('install/common.admin_account'),
            'admin_password' => trans('install/common.admin_password'),
        ];
    }
}
