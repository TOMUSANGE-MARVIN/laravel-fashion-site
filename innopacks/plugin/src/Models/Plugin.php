<?php
/* */

namespace InnoShop\Plugin\Models;

use InnoShop\Common\Models\BaseModel;

class Plugin extends BaseModel
{
    protected $table = 'plugins';

    protected $fillable = ['type', 'code', 'priority'];
}
