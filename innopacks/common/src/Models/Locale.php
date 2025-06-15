<?php
/* */

namespace InnoShop\Common\Models;

class Locale extends BaseModel
{
    protected $fillable = [
        'name', 'code', 'image', 'position', 'active',
    ];
}
