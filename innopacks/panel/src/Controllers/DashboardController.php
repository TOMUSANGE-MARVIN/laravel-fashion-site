<?php
/* */

namespace InnoShop\Panel\Controllers;

use InnoShop\Panel\Repositories\Dashboard\OrderRepo;
use InnoShop\Panel\Repositories\Dashboard\ProductRepo;
use InnoShop\Panel\Repositories\DashboardRepo;

class DashboardController extends BaseController
{
    /**
     * Dashboard for panel home page.
     *
     * @return mixed
     * @throws \Exception
     */
    public function index(): mixed
    {
        $data = [
            'cards' => DashboardRepo::getInstance()->getCards(),
            'order' => [
                'latest_week' => OrderRepo::getInstance()->getOrderCountLatestWeek(),
            ],
            'top_sale_products' => ProductRepo::getInstance()->getTopSaleProducts(),
        ];

        return inno_view('panel::dashboard', $data);
    }
}
