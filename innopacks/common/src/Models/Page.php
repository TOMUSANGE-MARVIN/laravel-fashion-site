<?php
/* */

namespace InnoShop\Common\Models;

use Exception;
use InnoShop\Common\Traits\Translatable;

class Page extends BaseModel
{
    use Translatable;

    protected $fillable = [
        'slug', 'viewed', 'show_breadcrumb', 'active',
    ];

    public $appends = [
        'url',
    ];

    /**
     * Get slug url link.
     *
     * @return string
     * @throws Exception
     */
    public function getUrlAttribute(): string
    {
        try {
            if ($this->slug) {
                return front_route('pages.'.$this->slug);
            }

            return front_route('pages.show', $this);
        } catch (Exception $e) {
            return '';
        }
    }
}
