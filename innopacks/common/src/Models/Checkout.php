<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkout extends BaseModel
{
    protected $table = 'checkout';

    protected $fillable = [
        'customer_id', 'guest_id', 'shipping_address_id', 'shipping_method_code', 'billing_address_id',
        'billing_method_code', 'reference',
    ];

    protected $casts = [
        'reference' => 'array',
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
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id', 'id');
    }
}
