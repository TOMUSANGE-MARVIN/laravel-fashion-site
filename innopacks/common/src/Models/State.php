<?php
/* */

namespace InnoShop\Common\Models;

class State extends BaseModel
{
    protected $table = 'states';

    protected $fillable = [
        'country_id', 'country_code', 'name', 'code', 'position', 'active',
    ];
}
