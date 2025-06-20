<?php
/* */

namespace InnoShop\Plugin\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use InnoShop\Plugin\Services\MarketplaceService;

class PluginMarketController
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
        $marketService = MarketplaceService::getInstance()
            ->setPage($request->get('page', 1))
            ->setPerPage($request->get('per_page', 8));

        if ($categorySlug) {
            $products = $marketService->getMarketProducts($categorySlug);
        } else {
            $products = $marketService->getPluginProducts();
        }

        $data = [
            'categories' => $marketService->getPluginCategories(),
            'products'   => $products,
        ];

        return inno_view('plugin::plugin_market.index', $data);
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
            'categories' => $marketService->getPluginCategories(),
            'product'    => $marketService->getProductDetail($slug),
        ];

        return inno_view('plugin::plugin_market.detail', $data);
    }
}
