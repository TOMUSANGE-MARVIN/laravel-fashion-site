<?php
/* */

namespace InnoShop\Front\Repositories;

use InnoShop\Common\Models\Category;
use InnoShop\Common\Models\Product;

class HomeRepo
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static;
    }

    /**
     * @return array
     */
    public function getSlideShow(): array
    {
        $slideShow = system_setting('slideshow');
        if (empty($slideShow)) {
            return [];
        }

        $result = [];
        foreach ($slideShow as $item) {
            if (str_starts_with($item['link'], 'category:')) {
                $categoryID = str_replace('category:', '', $item['link']);
                $category   = Category::query()->find($categoryID);
                if (empty($category)) {
                    $category = Category::query()->where('slug', $categoryID)->first();
                }
                $item['link'] = $category->url;
            } elseif (str_starts_with($item['link'], 'product:')) {
                $productID = str_replace('product:', '', $item['link']);
                $product   = Product::query()->find($productID);
                if (empty($product)) {
                    $product = Product::query()->where('slug', $productID)->first();
                }
                $item['link'] = $product->url;
            }
            $result[] = $item;
        }

        return $result;
    }
}
