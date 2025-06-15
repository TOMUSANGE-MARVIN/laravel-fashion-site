<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends BaseModel
{
    protected $table = 'regions';

    protected $fillable = [
        'name', 'description', 'position', 'active',
    ];

    /**
     * @return HasMany
     */
    public function regionStates(): HasMany
    {
        return $this->hasMany(\InnoShop\Common\Models\Region\State::class);
    }
}
