<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function login(Request $request): mixed
    {
        try {
            if (! Auth::guard('admin')->attempt($request->only(['email', 'password']))) {
                throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
            }
            $token = Auth::guard('admin')->user()->createToken('admin-token')->plainTextToken;

            return create_json_success(['token' => $token]);
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function admin(Request $request): mixed
    {
        $user = $request->user();

        return read_json_success($user);
    }
}
