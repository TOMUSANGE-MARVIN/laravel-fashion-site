<?php
/* */

namespace InnoShop\Panel\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InnoShop\Common\Repositories\AdminRepo;

class AccountController extends BaseController
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        $data = [
            'admin' => current_admin(),
        ];

        return inno_view('panel::account.index', $data);
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $admin = current_admin();
            AdminRepo::getInstance()->update($admin, $request->only('name', 'email', 'password'));

            return redirect(panel_route('account.index'))
                ->with('instance', $admin)
                ->with('success', panel_trans('common.updated_success'));

        } catch (\Exception $e) {
            return redirect(panel_route('account.index'))
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
