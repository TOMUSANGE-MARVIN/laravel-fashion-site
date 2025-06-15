<?php
/* */

namespace InnoShop\Common\Models\Product;

use InnoShop\Common\Models\BaseModel;

class Relation extends BaseModel
{
    protected $table = 'product_relations';

    protected $fillable = [
        'product_id', 'relation_id',
    ];
}
