<?php
/* */

namespace InnoShop\Common\Models;

class Setting extends BaseModel
{
    protected $fillable = [
        'space', 'name', 'value', 'json',
    ];
}
