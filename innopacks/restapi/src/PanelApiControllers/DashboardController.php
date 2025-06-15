<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return read_json_success(Auth::guard('admin')->user());
    }
}
