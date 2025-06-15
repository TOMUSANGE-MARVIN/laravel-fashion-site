<?php
/* */

namespace InnoShop\RestAPI\FrontApiControllers;

use Exception;

class SettingController extends BaseController
{
    /**
     * @return mixed
     * @throws Exception
     */
    public function index(): mixed
    {
        $settings = setting('system');

        $settings['locales']    = locales()->select(['name', 'code']);
        $settings['currencies'] = currencies()->select(['name', 'code']);

        return read_json_success($settings);
    }
}
