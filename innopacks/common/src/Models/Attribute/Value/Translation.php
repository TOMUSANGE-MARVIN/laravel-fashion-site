<?php
/* */

namespace InnoShop\Common\Models\Attribute\Value;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Attribute\Value;
use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'attribute_value_translations';

    protected $fillable = [
        'attribute_value_id', 'locale', 'name',
    ];

    /**
     * @return BelongsTo
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(Value::class, 'attribute_value_id', 'id');
    }
}
