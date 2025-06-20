<?php
/* */

namespace InnoShop\Panel\Repositories;

use Illuminate\Support\Str;
use InnoShop\Common\Repositories\SettingRepo;
use Throwable;

class ThemeRepo
{
    const SETTING_KEYS = [
        'menu_header_categories',
        'menu_header_catalogs',
        'menu_header_pages',
        'menu_header_specials',
        'menu_footer_categories',
        'menu_footer_catalogs',
        'menu_footer_pages',
        'menu_footer_specials',
    ];

    /**
     * @return self
     */
    public static function getInstance(): ThemeRepo
    {
        return new self;
    }

    /**
     * Get theme list from themes path.
     *
     * @return array
     */
    public function getListFromPath(): array
    {
        $path       = base_path('themes');
        $themePaths = glob($path.'/*');

        $themes = [];
        foreach ($themePaths as $themePath) {
            $theme    = trim(str_replace($path, '', $themePath), '/');
            $themes[] = [
                'code'    => $theme,
                'name'    => Str::studly($theme),
                'value'   => system_setting('theme') == $theme,
                'preview' => $this->getPreviewPath($theme),
            ];
        }

        return $themes;
    }

    /**
     * @param  $settings
     * @return void
     * @throws Throwable
     */
    public function updateSetting($settings): void
    {
        foreach (self::SETTING_KEYS as $key) {
            $settings[$key] = $settings[$key] ?? [];
        }
        SettingRepo::getInstance()->updateValues($settings);
    }

    /**
     * @param  string  $themeCode
     * @return string
     */
    private function getPreviewPath(string $themeCode): string
    {
        $path = theme_path($themeCode.'/public/images/preview.png');
        if (file_exists($path)) {
            return 'images/preview.png';
        }

        $path = theme_path($themeCode.'/public/images/preview.jpg');
        if (file_exists($path)) {
            return 'images/preview.jpg';
        }

        return '';
    }
}
