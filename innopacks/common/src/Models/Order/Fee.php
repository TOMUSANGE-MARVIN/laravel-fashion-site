<?php
/* */

namespace InnoShop\Common\Models\Order;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Order;

class Fee extends BaseModel
{
    protected $table = 'order_fees';

    protected $fillable = [
        'order_id', 'code', 'value', 'title', 'reference',
    ];

    protected $casts = [
        'reference' => 'array',
    ];

    protected $appends = [
        'value_format',
    ];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * @return string
     */
    public function getValueFormatAttribute(): string
    {
        $order = $this->order;

        return currency_format($this->value, $order->currency_code, $order->currency_value);
    }
}
