<?php
/* */

namespace InnoShop\Common\Models\Product;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Attribute\Value;
use InnoShop\Common\Models\BaseModel;

class Attribute extends BaseModel
{
    protected $table = 'product_attributes';

    protected $fillable = [
        'product_id', 'attribute_id', 'attribute_value_id',
    ];

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(\InnoShop\Common\Models\Attribute::class, 'attribute_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(Value::class, 'attribute_value_id', 'id');
    }
}
