<?php
/* */

namespace InnoShop\Front\Controllers\Account;

use App\Http\Controllers\Controller;
use Exception;
use InnoShop\Common\Services\CartService;
use InnoShop\Front\Requests\RegisterRequest;
use InnoShop\Front\Services\AccountService;
use Throwable;

class RegisterController extends Controller
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

        return inno_view('account.register');
    }

    /**
     * @param  RegisterRequest  $request
     * @return mixed
     * @throws Throwable
     */
    public function store(RegisterRequest $request): mixed
    {
        try {
            $oldGuestId  = current_guest_id();
            $credentials = $request->only('email', 'password');
            $customer    = AccountService::getInstance()->register($credentials);
            auth('customer')->attempt($credentials);

            CartService::getInstance(current_customer_id())->mergeCart($oldGuestId);

            return json_success(front_trans('register.register_success'), ['customer' => $customer]);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
