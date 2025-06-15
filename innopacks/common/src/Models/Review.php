<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Order\Item;

class Review extends BaseModel
{
    protected $table = 'reviews';

    protected $fillable = [
        'customer_id', 'product_id', 'order_item_id', 'rating', 'content', 'like', 'dislike', 'active',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'order_item_id', 'id');
    }
}
