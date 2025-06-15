<?php
/* */

namespace InnoShop\Common\Models;

class TaxRule extends BaseModel
{
    protected $table = 'tax_rules';

    protected $fillable = [
        'tax_class_id', 'tax_rate_id', 'based', 'priority',
    ];
}
