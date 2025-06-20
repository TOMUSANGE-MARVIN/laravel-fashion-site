<?php
/* */

namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use InnoShop\Common\Repositories\ArticleRepo;
use InnoShop\Common\Repositories\ProductRepo;
use InnoShop\Front\Repositories\HomeRepo;

class HomeController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function index(): mixed
    {
        $bestSeller  = ProductRepo::getInstance()->getBestSellerProducts();
        $newArrivals = ProductRepo::getInstance()->getLatestProducts();
        $tabProducts = [
            ['tab_title' => trans('front/home.bestseller'), 'products' => $bestSeller],
            ['tab_title' => trans('front/home.new_arrival'), 'products' => $newArrivals],
        ];

        $news = ArticleRepo::getInstance()->getLatestArticles();
        $data = [
            'slideshow'    => HomeRepo::getInstance()->getSlideShow(),
            'tab_products' => $tabProducts,
            'news'         => $news,
        ];

        $data = fire_hook_filter('home.index.data', $data);

        return inno_view('home', $data);
    }
}
