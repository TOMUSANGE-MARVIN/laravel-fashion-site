<?php
/* */

namespace InnoShop\Common\Models\Product;

use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'product_translations';

    protected $fillable = [
        'product_id', 'locale', 'name', 'summary', 'content', 'selling_point', 'meta_title', 'meta_description',
        'meta_keywords',
    ];
}
