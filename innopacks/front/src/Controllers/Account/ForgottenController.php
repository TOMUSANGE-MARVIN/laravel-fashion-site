<?php
/* */

namespace InnoShop\Front\Controllers\Account;

use App\Http\Controllers\Controller;
use Exception;
use InnoShop\Front\Requests\ForgottenRequest;
use InnoShop\Front\Requests\VerifyCodeRequest;
use InnoShop\Front\Services\AccountService;

class ForgottenController extends Controller
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return view('account.forgotten');
    }

    /**
     * Receive the email address, generate a verification code, and send it to the email address.
     *
     * @param  VerifyCodeRequest  $request
     * @return mixed
     */
    public function sendVerifyCode(VerifyCodeRequest $request): mixed
    {
        try {
            $email = $request['email'];
            AccountService::getInstance()->sendVerifyCode($email);

            return json_success(front_trans('forgotten.verification_code_sent'));
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * Receive the verification code and new password, confirm the password, check if the verification code is correct,
     * and if the password matches the confirmed password, then change the password.
     *
     * @param  ForgottenRequest  $request
     * @return mixed
     * @throws Exception
     */
    public function changePassword(ForgottenRequest $request): mixed
    {
        try {
            $code     = $request['code'];
            $email    = $request['email'];
            $password = $request['password'];

            AccountService::getInstance()->verifyUpdatePassword($code, $email, $password);

            return json_success(front_trans('forgotten.password_updated'));
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
