<?php
/* */

namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function switch(Request $request): RedirectResponse
    {
        $currentCode = App::getLocale();
        $destCode    = $request->code;
        $refererUrl  = $request->headers->get('referer');
        $baseUrl     = url('/').'/';

        $newUrl = str_replace($baseUrl.$currentCode, $baseUrl.$destCode, $refererUrl);
        App::setLocale($destCode);
        session(['locale' => $destCode]);

        return redirect()->to($newUrl);
    }
}
