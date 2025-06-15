<?php
/* */

namespace InnoShop\Common\Models\Region;

use InnoShop\Common\Models\BaseModel;

class State extends BaseModel
{
    protected $table = 'region_states';

    protected $fillable = [
        'country_id', 'state_id',
    ];
}
