<?php
/* */

namespace InnoShop\Front\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed|min:6',
        ];
    }

    public function attributes(): array
    {
        return [
            'old_password' => front_trans('password.old_password'),
            'new_password' => front_trans('password.new_password'),
        ];
    }
}
