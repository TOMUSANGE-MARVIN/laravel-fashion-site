<?php
/* */

namespace InnoShop\Front\Controllers\Account;

use App\Http\Controllers\Controller;
use Exception;
use InnoShop\Common\Services\CartService;
use InnoShop\Front\Requests\LoginRequest;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoginController extends Controller
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function index(): mixed
    {
        if (current_customer()) {
            return redirect(front_route('account.index'));
        }

        return inno_view('account.login');
    }

    /**
     * Login request
     *
     * @param  LoginRequest  $request
     * @return mixed
     */
    public function store(LoginRequest $request): mixed
    {
        try {
            $oldGuestId  = current_guest_id();
            $redirectUri = session('front_redirect_uri');

            if (!auth('customer')->attempt([
                'email' => $request['email'],
                'password' => $request['password']
            ])) {
                throw new NotAcceptableHttpException(front_trans('login.account_or_password_error'));
            }

            $customer = current_customer();
            if (empty($customer)) {
                throw new NotFoundHttpException(front_trans('login.empty_customer'));
            }

            if (! $customer->active) {
                auth('customer')->logout();
                throw new Exception(front_trans('login.inactive_customer'));
            }

            CartService::getInstance(current_customer_id())->mergeCart($oldGuestId);
            session()->forget('front_redirect_uri');
            $data = ['redirect_uri' => $redirectUri];

            return json_success(front_trans('login.login_success'), $data);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
