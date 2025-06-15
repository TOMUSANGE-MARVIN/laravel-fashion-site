<?php
/* */

namespace InnoShop\Panel\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class SetPanelLocale
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
        $frontLocales = locales();
        $frontLocale  = front_locale_code();

        $panelLocales  = panel_locales();
        $currentLocale = panel_locale_code();

        if (collect($panelLocales)->contains('code', $currentLocale)) {
            if (! $frontLocales->contains('code', $currentLocale)) {
                session(['locale' => $frontLocale]);
            }
            app()->setLocale($currentLocale);
        } else {
            session(['locale' => $frontLocale]);
            app()->setLocale($frontLocale);
        }

        return $next($request);
    }
}
