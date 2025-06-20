<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
        if ($this->state) {
            $slugRule = 'alpha_dash|unique:states,code,'.$this->state->id;
        } else {
            $slugRule = 'alpha_dash|unique:states,code';
        }

        return [
            'country_id'   => 'integer|required',
            'country_code' => 'string|required|max:2',
            'name'         => 'string|required|max:32',
            'code'         => $slugRule,
            'position'     => 'string',
            'active'       => 'bool',
        ];
    }
}
