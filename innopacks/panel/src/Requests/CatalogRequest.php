<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogRequest extends FormRequest
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
        if ($this->catalog) {
            $slugRule = 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:catalogs,slug,'.$this->catalog->id;
        } else {
            $slugRule = 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:catalogs,slug';
        }

        $defaultLocale = setting_locale_code();

        return [
            'slug'     => $slugRule,
            'position' => 'integer',
            'active'   => 'bool',

            "translations.$defaultLocale.locale" => 'required',
            "translations.$defaultLocale.title"  => 'required',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        $defaultLocale = setting_locale_code();

        return [
            'slug'                               => panel_trans('common.slug'),
            "translations.$defaultLocale.locale" => trans('panel/catalog.locale'),
            "translations.$defaultLocale.title"  => trans('panel/catalog.title'),
        ];
    }
}
