<?php
/* */

namespace InnoShop\Common\Models\Attribute;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Attribute;
use InnoShop\Common\Models\BaseModel;

class Translation extends BaseModel
{
    protected $table = 'attribute_translations';

    protected $fillable = [
        'locale', 'name',
    ];

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
