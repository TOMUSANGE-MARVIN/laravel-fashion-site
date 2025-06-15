<?php
/* */

namespace InnoShop\Common\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxRate extends BaseModel
{
    protected $table = 'tax_rates';

    protected $fillable = [
        'region_id', 'name', 'type', 'rate',
    ];

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
