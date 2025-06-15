<?php
/* */

namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;

class MaintenanceController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function index(): mixed
    {
        return inno_view('maintenance');
    }
}
