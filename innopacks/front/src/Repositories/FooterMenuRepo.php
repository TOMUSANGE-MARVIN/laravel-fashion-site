<?php
/* */

namespace InnoShop\Front\Repositories;

use Exception;
use InnoShop\Common\Repositories\CatalogRepo;
use InnoShop\Common\Repositories\CategoryRepo;
use InnoShop\Common\Repositories\PageRepo;
use InnoShop\Common\Repositories\SpecialPageRepo;
use InnoShop\Common\Resources\CatalogSimple;
use InnoShop\Common\Resources\PageSimple;

class FooterMenuRepo
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static;
    }

    /**
     * Generate header menus for frontend.
     *
     * @return array
     * @throws Exception
     */
    public function getMenus(): array
    {
        $menus = [
            'categories' => $this->getCategories(system_setting('menu_footer_categories')),
            'catalogs'   => $this->getCatalogs(system_setting('menu_footer_catalogs')),
            'pages'      => $this->getPages(system_setting('menu_footer_pages')),
            'specials'   => $this->getSpecials(system_setting('menu_footer_specials')),
        ];

        return fire_hook_filter('global.footer.menus', $menus);
    }

    /**
     * @param  $specials
     * @return array
     * @throws Exception
     */
    public function getSpecials($specials): array
    {
        if (empty($specials)) {
            return [];
        }

        return SpecialPageRepo::getInstance()->getSpecialLinks($specials);
    }

    /**
     * @param  $categoryIds
     * @return array
     */
    private function getCategories($categoryIds): array
    {
        if (empty($categoryIds)) {
            return [];
        }

        return CategoryRepo::getInstance()->getTwoLevelCategories($categoryIds);
    }

    /**
     * @param  $catalogIds
     * @return array
     */
    private function getCatalogs($catalogIds): array
    {
        if (empty($catalogIds)) {
            return [];
        }

        $catalogs = CatalogRepo::getInstance()
            ->builder(['active' => true, 'parent_id' => 0, 'catalog_ids' => $catalogIds])
            ->orderBy('position')
            ->get();

        return CatalogSimple::collection($catalogs)->jsonSerialize();
    }

    /**
     * @param  $pageIds
     * @return array
     */
    private function getPages($pageIds): array
    {
        if (empty($pageIds)) {
            return [];
        }

        $catalogs = PageRepo::getInstance()
            ->builder(['active' => true, 'page_ids' => $pageIds])
            ->orderBy('position')
            ->get();

        return PageSimple::collection($catalogs)->jsonSerialize();
    }
}
