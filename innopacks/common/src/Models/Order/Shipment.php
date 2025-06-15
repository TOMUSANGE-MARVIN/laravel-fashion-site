<?php
/* */

namespace InnoShop\Common\Models\Order;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Order;

class Shipment extends BaseModel
{
    protected $table = 'order_shipments';

    protected $fillable = [
        'order_id', 'express_code', 'express_company', 'express_number',
    ];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
