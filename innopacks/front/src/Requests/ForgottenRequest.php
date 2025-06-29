<?php
/* */

namespace InnoShop\Front\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgottenRequest extends FormRequest
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
            'password' => 'required|confirmed',
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => front_trans('forgotten.password'),
        ];
    }
}
