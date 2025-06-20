<?php
/* */

namespace InnoShop\Front\Components;

use Exception;
use Illuminate\View\Component;
use InnoShop\Common\Libraries\Breadcrumb as BreadcrumbLib;

class Breadcrumb extends Component
{
    public array $breadcrumbs;

    public bool $showFilter = false;

    /**
     * @param  $type
     * @param  $value
     * @param  string  $title
     * @throws Exception
     */
    public function __construct($type, $value, string $title = '')
    {
        $this->breadcrumbs[] = [
            'title' => front_trans('common.home'),
            'url'   => front_route('home.index'),
        ];

        $breadcrumbLib = BreadcrumbLib::getInstance();

        $accountRoutes = [
            'account.orders.index',
            'account.favorites.index',
            'account.reviews.index',
            'account.addresses.index',
            'account.order_returns.index',
            'account.edit.index',
            'account.password.index',
        ];

        if (in_array($type, ['order', 'order_return']) || in_array($value, $accountRoutes)) {
            $this->breadcrumbs[] = $breadcrumbLib->getTrail('route', 'account.index', front_trans('account.account'));
        }

        if ($type == 'order') {
            $this->breadcrumbs[] = $breadcrumbLib->getTrail('route', 'account.orders.index', front_trans('account.orders'));
        } elseif ($type == 'order_return') {
            $this->breadcrumbs[] = $breadcrumbLib->getTrail('route', 'account.order_returns.index', front_trans('account.order_returns'));
        } elseif ($type == 'brand') {
            $this->breadcrumbs[] = $breadcrumbLib->getTrail('route', 'brands.index', front_trans('product.brand'));
        }

        $this->breadcrumbs[] = $breadcrumbLib->getTrail($type, $value, $title);

        if (equal_route_name('front.categories.slug_show') || equal_route_name('front.categories.slug_show') || equal_route_name('front.products.index')) {
            $this->showFilter = true;
        }
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('components.breadcrumb');
    }
}
