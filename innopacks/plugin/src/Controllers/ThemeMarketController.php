<?php
/* */

namespace InnoShop\Plugin\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use InnoShop\Plugin\Services\MarketplaceService;

class ThemeMarketController
{
    /**
     * Get plugins market categories and items.
     *
     * @param  Request  $request
     * @return mixed
     * @throws ConnectionException
     */
    public function index(Request $request): mixed
    {
        $categorySlug  = $request->get('category');
        $marketService = MarketplaceService::getInstance();

        if ($categorySlug) {
            $products = $marketService->getMarketProducts($categorySlug);
        } else {
            $products = $marketService->getThemeProducts();
        }

        $data = [
            'categories' => $marketService->getThemeCategories(),
            'products'   => $products,
        ];

        return inno_view('plugin::theme_market.index', $data);
    }

    /**
     * @param  int  $slug
     * @return mixed
     * @throws ConnectionException
     */
    public function show(int $slug): mixed
    {
        $marketService = MarketplaceService::getInstance();

        $data = [
            'categories' => $marketService->getThemeCategories(),
            'product'    => $marketService->getProductDetail($slug),
        ];

        return inno_view('plugin::theme_market.detail', $data);
    }
}
