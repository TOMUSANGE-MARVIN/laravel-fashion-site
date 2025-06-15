<?php
/* */

namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use InnoShop\Common\Repositories\PageRepo;

class PageController extends Controller
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws \Exception
     */
    public function show(Request $request): mixed
    {
        $locale = front_locale_code();
        if (count(locales()) == 1) {
            $slug = trim($request->getRequestUri(), '/');
        } else {
            $slug = str_replace("/$locale/", '', $request->getRequestUri());
        }
        $filters = [
            'slug'   => $slug,
            'active' => true,
        ];
        $page = PageRepo::getInstance()->builder($filters)->firstOrFail();
        $page->increment('viewed');

        $data = [
            'slug' => $slug,
            'page' => $page,
        ];
        $template = $page->translation->template ?? '';
        if ($template) {
            $result         = Blade::render($template, $data);
            $data['result'] = $result;
        }

        return inno_view('pages.show', $data);
    }
}
