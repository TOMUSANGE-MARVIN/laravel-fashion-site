<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxClass extends BaseModel
{
    protected $table = 'tax_classes';

    protected $fillable = [
        'name', 'description',
    ];

    /**
     * @return HasMany
     */
    public function taxRules(): HasMany
    {
        return $this->hasMany(TaxRule::class);
    }
}
