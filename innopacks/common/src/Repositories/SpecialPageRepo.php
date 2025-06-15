<?php
/* */

namespace InnoShop\Common\Repositories;

use Exception;

class SpecialPageRepo
{
    public static function getInstance(): static
    {
        return new static;
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function getOptions(): array
    {
        $specialOptions = [
            ['type' => 'products', 'title' => trans('panel/setting.products'), 'route' => 'products.index'],
            ['type' => 'brands', 'title' => trans('panel/setting.brands'), 'route' => 'brands.index'],
        ];

        return fire_hook_filter('repo.special.options', $specialOptions);
    }

    /**
     * @param  $specials
     * @return array
     * @throws Exception
     */
    public function getSpecialLinks($specials): array
    {
        if (empty($specials)) {
            return [];
        }

        $items = [];
        foreach ($specials as $special) {
            if ($special == 'brands') {
                $url = front_route('brands.index');
            } elseif ($special == 'products') {
                $url = front_route('products.index');
            } else {
                continue;
            }
            $items[] = [
                'name' => trans('front/common.'.$special),
                'url'  => $url,
            ];
        }

        return fire_hook_filter('repo.special.links', $items);
    }
}
