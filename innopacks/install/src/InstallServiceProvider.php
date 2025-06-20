<?php
/* */

namespace InnoShop\Install;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class InstallServiceProvider extends ServiceProvider
{
    /**
     * Boot front service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerWebRoutes();
        $this->loadTranslations();
        $this->loadViewTemplates();
    }

    /**
     * Register admin front routes.
     *
     * @return void
     */
    protected function registerWebRoutes(): void
    {
        Route::name('install.')
            ->group(function () {
                $this->loadRoutesFrom(realpath(__DIR__.'/../routes/web.php'));
            });
    }

    /**
     * Register front language
     * @return void
     */
    protected function loadTranslations(): void
    {
        if (! is_dir(__DIR__.'/../lang')) {
            return;
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'install');
    }

    /**
     * Load templates
     *
     * @return void
     */
    private function loadViewTemplates(): void
    {
        $originViewPath = inno_path('install/resources/views');
        $this->loadViewsFrom($originViewPath, 'install');
    }
}
