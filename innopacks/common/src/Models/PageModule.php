<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageModule extends BaseModel
{
    protected $table = 'page_modules';

    protected $fillable = [
        'page_id', 'module_data',
    ];

    protected $casts = [
        'module_data' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
