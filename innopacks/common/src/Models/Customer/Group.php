<?php
/* */

namespace InnoShop\Common\Models\Customer;

use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Traits\Translatable;

class Group extends BaseModel
{
    use Translatable;

    protected $table = 'customer_groups';

    protected $fillable = [
        'level', 'mini_cost', 'discount_rate',
    ];

    public function getForeignKey()
    {
        return 'customer_group_id';
    }
}
