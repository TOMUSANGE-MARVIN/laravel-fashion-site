<?php
/* */

namespace InnoShop\Common\Middleware;

use Closure;
use Illuminate\Http\Request;

class EventActionHook
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $hookName = $this->parseHookName($request);
        fire_hook_action($hookName.'.before', $request);

        $response = $next($request);

        $request->merge(['response' => $response]);
        fire_hook_action($hookName.'.after', $request);

        return $response;
    }

    /**
     * Parse hook name
     *
     * @param  Request  $request
     * @return string
     */
    private function parseHookName(Request $request): string
    {
        $route            = $request->route();
        $controllerAction = $route->getActionName();
        $controllerAction = str_replace(['InnoShop\\', 'Controllers\\'], '', $controllerAction);
        $controllerAction = str_replace('Controller@', '\\', $controllerAction);
        $controllerAction = trim($controllerAction, '\\');

        return strtolower(str_replace('\\', '.', $controllerAction));
    }
}
