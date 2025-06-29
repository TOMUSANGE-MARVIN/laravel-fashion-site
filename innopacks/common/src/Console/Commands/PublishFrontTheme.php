<?php
/* */

namespace InnoShop\Common\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishFrontTheme extends Command
{
    protected $signature = 'inno:publish-theme';

    protected $description = 'Publish default theme for frontend.';

    public function handle(): void
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'InnoShop\Front\FrontServiceProvider',
            '--tag'      => 'views',
        ]);
        echo Artisan::output();
    }
}
