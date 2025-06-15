<?php
/* */

namespace InnoShop\Common\Models\Tag;

use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'tag_translations';

    protected $fillable = [
        'tag_id', 'locale', 'name',
    ];
}
