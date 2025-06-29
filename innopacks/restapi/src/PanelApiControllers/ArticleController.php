<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use InnoShop\Common\Models\Article;
use InnoShop\Common\Repositories\ArticleRepo;
use InnoShop\Common\Resources\ArticleName;
use InnoShop\Panel\Requests\ArticleRequest;
use Throwable;

class ArticleController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request): mixed
    {
        $filters = $request->all();

        return ArticleRepo::getInstance()->list($filters);
    }

    /**
     * @param  Request  $request
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function names(Request $request): AnonymousResourceCollection
    {
        $articles = ArticleRepo::getInstance()->getListByArticleIDs($request->get('ids'));

        return ArticleName::collection($articles);
    }

    /**
     * @param  ArticleRequest  $request
     * @return mixed
     * @throws Throwable
     */
    public function store(ArticleRequest $request): mixed
    {
        try {
            $data    = $request->all();
            $article = ArticleRepo::getInstance()->create($data);

            return json_success(panel_trans('common.updated_success'), $article);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  ArticleRequest  $request
     * @param  Article  $article
     * @return mixed
     */
    public function update(ArticleRequest $request, Article $article): mixed
    {
        try {
            $data = $request->all();
            ArticleRepo::getInstance()->update($article, $data);

            return json_success(panel_trans('common.updated_success'), $article);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * @param  Article  $article
     * @return mixed
     */
    public function destroy(Article $article): mixed
    {
        try {
            ArticleRepo::getInstance()->destroy($article);

            return json_success(panel_trans('common.deleted_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * Fuzzy search for auto complete.
     * /api/panel/articles/autocomplete?keyword=xxx
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function autocomplete(Request $request): AnonymousResourceCollection
    {
        $categories = ArticleRepo::getInstance()->autocomplete($request->get('keyword') ?? '');

        return ArticleName::collection($categories);
    }
}
