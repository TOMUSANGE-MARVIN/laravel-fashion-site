<?php
/* */

namespace InnoShop\RestAPI\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class SetAPICurrency
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
        $currentCurrency = $request->header('currency');
        if (empty($currentCurrency)) {
            $currentCurrency = $request->get('currency');
        }
        $availableCurrencies = currencies()->pluck('code')->toArray();
        if (! in_array($currentCurrency, $availableCurrencies)) {
            $currentCurrency = system_setting('currency', 'usd');
        }

        if (env('APP_CURRENCY_FORCE')) {
            $currentCurrency = env('APP_LOCALE_FORCE');
        }

        session(['currency' => $currentCurrency]);

        return $next($request);
    }
}
