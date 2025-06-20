<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use InnoShop\Common\Models\Catalog;
use InnoShop\Common\Repositories\CatalogRepo;
use InnoShop\Common\Resources\CatalogName;
use InnoShop\Panel\Requests\CatalogRequest;
use Throwable;

class CatalogController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request): mixed
    {
        $filters = $request->all();

        return CatalogRepo::getInstance()->list($filters);
    }

    /**
     * @param  Request  $request
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function names(Request $request): AnonymousResourceCollection
    {
        $catalogs = CatalogRepo::getInstance()->getListByCatalogIDs($request->get('ids'));

        return CatalogName::collection($catalogs);
    }

    /**
     * @param  CatalogRequest  $request
     * @return mixed
     * @throws Throwable
     */
    public function store(CatalogRequest $request): mixed
    {
        try {
            $data    = $request->all();
            $catalog = CatalogRepo::getInstance()->create($data);

            return json_success(panel_trans('common.updated_success'), $catalog);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  CatalogRequest  $request
     * @param  Catalog  $catalog
     * @return mixed
     */
    public function update(CatalogRequest $request, Catalog $catalog): mixed
    {
        try {
            $data = $request->all();
            CatalogRepo::getInstance()->update($catalog, $data);

            return json_success(panel_trans('common.updated_success'), $catalog);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  Catalog  $catalog
     * @return mixed
     */
    public function destroy(Catalog $catalog): mixed
    {
        try {
            CatalogRepo::getInstance()->destroy($catalog);

            return json_success(panel_trans('common.deleted_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * Fuzzy search for auto complete.
     * /api/panel/catalogs/autocomplete?keyword=xxx
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function autocomplete(Request $request): AnonymousResourceCollection
    {
        $catalogs = CatalogRepo::getInstance()->autocomplete($request->get('keyword') ?? '');

        return CatalogName::collection($catalogs);
    }
}
