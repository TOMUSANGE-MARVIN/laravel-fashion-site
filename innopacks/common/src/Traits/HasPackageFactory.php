<?php
/* */

namespace InnoShop\Common\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

trait HasPackageFactory
{
    use HasFactory;

    protected static function newFactory()
    {
        $package   = Str::before(get_called_class(), 'Models\\');
        $modelName = Str::after(get_called_class(), 'Models\\');
        $path      = $package.'Factories\\'.$modelName.'Factory';

        return new $path;
    }
}
