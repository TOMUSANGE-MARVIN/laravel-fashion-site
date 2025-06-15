<?php
/* */

namespace InnoShop\Common\Models\Order;

use InnoShop\Common\Models\BaseModel;

class Payment extends BaseModel
{
    protected $table = 'order_payments';

    protected $fillable = [
        'order_id', 'charge_id', 'amount', 'handling_fee', 'paid', 'reference',
    ];
}
