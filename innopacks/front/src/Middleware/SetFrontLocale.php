<?php
/* */

namespace InnoShop\Front\Middleware;

use Illuminate\Http\Request;

class SetFrontLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, \Closure $next): mixed
    {
        $currentLocale = $request->segment(1);
        if (empty($currentLocale)) {
            $currentLocale = front_locale_code();
        }

        $availableLocales = locales()->pluck('code')->toArray();
        if (! in_array($currentLocale, $availableLocales)) {
            $currentLocale = setting_locale_code();
        }

        if (env('APP_LOCALE_FORCE')) {
            $currentLocale = env('APP_LOCALE_FORCE');
        }

        app()->setLocale($currentLocale);
        session(['locale' => $currentLocale]);

        return $next($request);
    }
}
