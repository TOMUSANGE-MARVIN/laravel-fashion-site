<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Illuminate\Http\Request;
use InnoShop\Common\Repositories\AttributeRepo;
use InnoShop\Common\Resources\AttributeSimple;

class AttributeController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $filters    = $request->all();
        $attributes = AttributeRepo::getInstance()->all($filters);
        $items      = AttributeSimple::collection($attributes);

        return read_json_success($items);
    }
}
