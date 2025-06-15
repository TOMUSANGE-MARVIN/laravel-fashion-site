<?php
/* */

namespace InnoShop\Front\Controllers;

use Exception;
use Illuminate\Http\Request;
use InnoShop\Front\Services\SitemapService;

class SitemapController
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request): mixed
    {
        try {
            return SitemapService::getInstance()->response($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
