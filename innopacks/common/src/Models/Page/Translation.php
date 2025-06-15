<?php
/* */

namespace InnoShop\Common\Models\Page;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Page;

class Translation extends BaseModel
{
    protected $table = 'page_translations';

    protected $fillable = [
        'page_id', 'locale', 'title', 'content', 'template', 'meta_title', 'meta_description', 'meta_keywords',
    ];

    /**
     * @return BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
