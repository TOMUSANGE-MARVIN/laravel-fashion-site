<?php
/* */

namespace InnoShop\Common\Models\Customer\Group;

use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'customer_group_translations';

    protected $fillable = [
        'locale', 'name', 'description',
    ];
}
