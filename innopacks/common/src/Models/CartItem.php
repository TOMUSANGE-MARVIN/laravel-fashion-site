<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends BaseModel
{
    protected $table = 'cart_items';

    protected $fillable = [
        'customer_id', 'product_id', 'sku_code', 'guest_id', 'selected', 'quantity',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productSku(): BelongsTo
    {
        return $this->belongsTo(Product\Sku::class, 'sku_code', 'code');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function getSubtotalAttribute(): float
    {
        $sku   = $this->productSku;
        $price = $sku->getFinalPrice();

        return round($price * $this->quantity, 2);
    }
}
