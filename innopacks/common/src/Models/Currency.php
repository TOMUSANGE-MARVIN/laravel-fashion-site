<?php
/* */

namespace InnoShop\Common\Models;

class Currency extends BaseModel
{
    protected $table = 'currencies';

    protected $fillable = [
        'name', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'active',
    ];
}
