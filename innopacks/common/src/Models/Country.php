<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends BaseModel
{
    protected $table = 'countries';

    protected $fillable = [
        'name', 'code', 'continent', 'position', 'active',
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
}
