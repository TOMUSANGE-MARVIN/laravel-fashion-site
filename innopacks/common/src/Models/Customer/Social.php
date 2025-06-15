<?php
/* */

namespace InnoShop\Common\Models\Customer;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Customer;

class Social extends BaseModel
{
    protected $table = 'customer_socials';

    protected $fillable = [
        'customer_id', 'provider', 'user_id', 'union_id', 'access_token', 'refresh_token', 'reference',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
