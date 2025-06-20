<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InnoShop\Common\Traits\Translatable;

class Catalog extends BaseModel
{
    use Translatable;

    protected $fillable = [
        'parent_id', 'slug', 'position', 'active',
    ];

    public $appends = [
        'url',
    ];

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Catalog::class, 'parent_id', 'id');
    }

    /**
     * Get slug url link.
     *
     * @return string
     * @throws \Exception
     */
    public function getUrlAttribute(): string
    {
        if ($this->slug) {
            return front_route('catalogs.slug_show', ['slug' => $this->slug]);
        }

        return front_route('catalogs.show', $this);
    }
}
