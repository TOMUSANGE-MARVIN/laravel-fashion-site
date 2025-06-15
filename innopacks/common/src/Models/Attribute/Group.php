<?php
/* */

namespace InnoShop\Common\Models\Attribute;

use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Traits\Translatable;

class Group extends BaseModel
{
    use Translatable;

    protected $table = 'attribute_groups';

    protected $fillable = [
        'position',
    ];

    public function getForeignKey(): string
    {
        return 'attribute_group_id';
    }
}
