<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InnoShop\Common\Traits\Translatable;

class Tag extends BaseModel
{
    use Translatable;

    protected $fillable = [
        'slug', 'position', 'active',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tags', 'tag_id', 'article_id');
    }

    /**
     * Get slug url link.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        if ($this->slug) {
            return front_route('tags.slug_show', ['slug' => $this->slug]);
        }

        return front_route('tags.show', $this);
    }
}
