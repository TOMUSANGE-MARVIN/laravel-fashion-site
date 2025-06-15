<?php
/* */

namespace InnoShop\Plugin\Models;

use InnoShop\Common\Models\BaseModel;

class Setting extends BaseModel
{
    protected $fillable = [
        'space', 'name', 'value', 'json',
    ];
}
