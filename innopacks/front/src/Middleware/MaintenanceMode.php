<?php
/* */

namespace InnoShop\Front\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class MaintenanceMode
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if (system_setting('maintenance_mode')) {
            if (current_admin()) {
                return $next($request);
            }

            $routeName = pure_route_name();

            if (! in_array($routeName, ['locales.switch', 'currencies.switch'])) {
                return response()->view('maintenance');
            }
        }

        return $next($request);
    }
}
