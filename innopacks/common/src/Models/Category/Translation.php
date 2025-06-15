<?php
/* */

namespace InnoShop\Common\Models\Category;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Category;

class Translation extends BaseModel
{
    protected $table = 'category_translations';

    protected $fillable = [
        'category_id', 'locale', 'name', 'content', 'meta_title', 'meta_description', 'meta_keywords',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
