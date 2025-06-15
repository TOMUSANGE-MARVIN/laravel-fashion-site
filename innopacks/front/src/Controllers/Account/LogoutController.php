<?php
/* */

namespace InnoShop\Front\Controllers\Account;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function index(): mixed
    {
        Auth::guard('customer')->logout();
        session()->forget('front_api_token');

        return redirect(front_route('home.index'));
    }
}
