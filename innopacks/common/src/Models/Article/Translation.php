<?php
/* */

namespace InnoShop\Common\Models\Article;

use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'article_translations';

    protected $fillable = [
        'title', 'summary', 'content', 'locale', 'image', 'meta_title', 'meta_description', 'meta_keywords',
    ];
}
