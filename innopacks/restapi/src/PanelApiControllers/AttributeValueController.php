<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Illuminate\Http\Request;
use InnoShop\Common\Repositories\Attribute\ValueRepo;
use InnoShop\Common\Resources\AttributeValueSimple;

class AttributeValueController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $filters = $request->all();
        $values  = ValueRepo::getInstance()->all($filters);
        $items   = AttributeValueSimple::collection($values);

        return read_json_success($items);
    }
}
