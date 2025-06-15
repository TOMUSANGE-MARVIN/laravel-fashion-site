<?php
/* */

namespace InnoShop\Panel\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class GlobalPanelData
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
        $currentAdmin  = current_admin();
        $panelApiToken = session('panel_api_token');
        if ($currentAdmin && empty($panelApiToken)) {
            $apiToken = $currentAdmin->createToken('admin-token')->plainTextToken;
            session(['panel_api_token' => $apiToken]);
        }

        view()->share('current_panel_locale', current_panel_locale());
        view()->share('admin', $currentAdmin);

        return $next($request);
    }
}
