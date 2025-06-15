<?php
/* */

namespace InnoShop\Panel\Controllers;

use Illuminate\Http\Request;
use InnoShop\Common\Repositories\Customer\SocialRepo;
use InnoShop\Common\Repositories\SettingRepo;
use Throwable;

class SocialController extends BaseController
{
    public function index()
    {
        $data = [
            'providers' => SocialRepo::getInstance()->getProviders(),
            'socials'   => system_setting('social', []),
        ];

        return inno_view('panel::socials.index', $data);
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws Throwable
     */
    public function store(Request $request): mixed
    {
        try {
            $data = $request->all();
            SettingRepo::getInstance()->updateSystemValue('social', $data);

            return update_json_success();
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
