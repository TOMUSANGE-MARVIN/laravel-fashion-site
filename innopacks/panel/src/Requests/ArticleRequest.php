<?php
/* */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        if ($this->article) {
            $slugRule = 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:articles,slug,'.$this->article->id;
        } else {
            $slugRule = 'nullable|regex:/^[a-zA-Z0-9-]+$/|unique:articles,slug';
        }

        $defaultLocale = setting_locale_code();

        return [
            'catalog_id' => 'integer',
            'slug'       => $slugRule,
            'position'   => 'integer',
            'viewed'     => 'integer',

            "translations.$defaultLocale.locale"  => 'required',
            "translations.$defaultLocale.title"   => 'required',
            "translations.$defaultLocale.content" => 'required|max:20000',

            'translations.*.summary'          => 'max:320',
            'translations.*.meta_title'       => 'max:256',
            'translations.*.meta_keywords'    => 'max:256',
            'translations.*.meta_description' => 'max:320',
        ];
    }

    public function attributes(): array
    {
        $defaultLocale = setting_locale_code();

        return [
            "translations.$defaultLocale.locale"  => trans('panel/article.locale'),
            "translations.$defaultLocale.title"   => trans('panel/article.title'),
            "translations.$defaultLocale.content" => trans('panel/article.content'),

            'translations.*.summary'          => trans('panel/article.summary'),
            'translations.*.meta_title'       => trans('panel/common.meta_title'),
            'translations.*.meta_keywords'    => trans('panel/common.meta_keywords'),
            'translations.*.meta_description' => trans('panel/common.meta_description'),
        ];
    }
}
