<?php
/* */

namespace InnoShop\Common\Models\Catalog;

use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'catalog_translations';

    protected $fillable = [
        'title', 'summary', 'locale', 'meta_title', 'meta_description', 'meta_keywords',
    ];
}
