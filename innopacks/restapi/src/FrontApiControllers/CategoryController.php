<?php
/* */

namespace InnoShop\RestAPI\FrontApiControllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use InnoShop\Common\Repositories\Category\TreeRepo;
use InnoShop\Common\Repositories\CategoryRepo;
use InnoShop\Common\Resources\CategorySimple;

class CategoryController extends BaseController
{
    /**
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->all();
        $perPage = $request->get('per_page', 15);

        $categories = CategoryRepo::getInstance()->withActive()->builder($filters)->paginate($perPage);

        return CategorySimple::collection($categories);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function tree(): mixed
    {
        $categoryTree = TreeRepo::getInstance()->getCategoryTree();

        return read_json_success($categoryTree);
    }
}
