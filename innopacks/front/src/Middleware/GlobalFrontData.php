<?php
/* */

namespace InnoShop\Front\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use InnoShop\Front\Repositories\FooterMenuRepo;
use InnoShop\Front\Repositories\HeaderMenuRepo;

class GlobalFrontData
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $customer = current_customer();
        $favTotal = $customer ? $customer->favorites->count() : 0;

        $frontApiToken = session('front_api_token');
        if ($customer && empty($frontApiToken)) {
            $apiToken = $customer->createToken('customer-token')->plainTextToken;
            session(['front_api_token' => $apiToken]);
        }

        view()->share('current_locale', current_locale());
        view()->share('header_menus', HeaderMenuRepo::getInstance()->getMenus());
        view()->share('footer_menus', FooterMenuRepo::getInstance()->getMenus());
        view()->share('customer', $customer);
        view()->share('fav_total', $favTotal);

        return $next($request);
    }
}
