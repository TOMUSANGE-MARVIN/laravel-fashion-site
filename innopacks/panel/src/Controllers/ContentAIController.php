<?php
/* */

namespace InnoShop\Panel\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentAIController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function generate(Request $request): mixed
    {
        try {
            $aiModel = system_setting('ai_model');
            if (empty($aiModel)) {
                throw new Exception('Empty AI Model');
            }

            $modelName = Str::studly($aiModel);
            $className = "Plugin\\$modelName\\Services\\{$modelName}Service";
            if (! class_exists($className)) {
                throw new Exception("Cannot found class $className");
            }

            if (! method_exists($className, 'complete')) {
                throw new Exception("Cannot found method complete for $className");
            }

            $data = [
                'message' => (new $className)->complete($request->all()),
            ];

            return read_json_success($data);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
