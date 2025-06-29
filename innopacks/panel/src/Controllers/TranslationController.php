<?php
/* */

namespace InnoShop\Panel\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use InnoShop\Panel\Requests\TranslateRequest;
use InnoShop\Panel\Services\TranslatorService;

class TranslationController extends Controller
{
    /**
     * @param  TranslateRequest  $request
     * @return mixed
     * @throws Exception
     */
    public function translate(TranslateRequest $request): mixed
    {
        try {
            $source = $request->get('source');
            $target = $request->get('target');
            $text   = $request->get('text');

            $response = TranslatorService::getInstance()->translate($source, $target, $text);

            return create_json_success($response);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
