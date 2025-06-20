<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocaleRequest extends FormRequest
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
        if ($this->locale) {
            $codeRule = 'required|alpha_dash|unique:locales,code,'.$this->locale->id;
        } else {
            $codeRule = 'required|alpha_dash|unique:locales,code';
        }

        return [
            'name'     => 'required',
            'code'     => $codeRule,
            'image'    => 'required',
            'position' => 'integer',
            'active'   => 'bool',
        ];
    }
}
