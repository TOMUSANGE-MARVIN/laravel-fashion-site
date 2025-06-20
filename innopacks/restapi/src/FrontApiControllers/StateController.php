<?php
/* */

namespace InnoShop\RestAPI\FrontApiControllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use InnoShop\Common\Repositories\StateRepo;
use InnoShop\Common\Resources\StateItem;

class StateController extends BaseController
{
    /**
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $states = StateRepo::getInstance()->builder($request->all())->get();

        return StateItem::collection($states);
    }
}
