<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InnoShop\Common\Models\Attribute\Group;
use InnoShop\Common\Models\Attribute\Value;
use InnoShop\Common\Traits\Translatable;

class Attribute extends BaseModel
{
    use Translatable;

    protected $table = 'attributes';

    protected $fillable = [
        'category_id', 'attribute_group_id', 'position',
    ];

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(Value::class);
    }

    /**
     * @return HasMany
     */
    public function productAttributes(): HasMany
    {
        return $this->hasMany(Product\Attribute::class, 'attribute_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'attribute_group_id', 'id');
    }
}
