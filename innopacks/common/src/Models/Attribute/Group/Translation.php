<?php
/* */

namespace InnoShop\Common\Models\Attribute\Group;

use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'attribute_group_translations';

    protected $fillable = [
        'attribute_group_id', 'locale', 'name',
    ];
}
