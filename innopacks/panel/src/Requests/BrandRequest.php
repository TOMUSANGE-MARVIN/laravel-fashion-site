<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        if ($this->brand) {
            $slugRule = 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:brands,slug,'.$this->brand->id;
        } else {
            $slugRule = 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:brands,slug';
        }

        return [
            'name'   => 'string|required|max:32',
            'slug'   => $slugRule,
            'first'  => 'string|required',
            'logo'   => 'required',
            'active' => 'bool',
        ];
    }
}
