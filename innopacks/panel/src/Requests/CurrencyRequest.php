<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            'name'          => 'required',
            'code'          => 'required|string',
            'decimal_place' => 'required|integer',
            'value'         => 'required|numeric',
            'active'        => 'required|bool',
        ];
    }
}
