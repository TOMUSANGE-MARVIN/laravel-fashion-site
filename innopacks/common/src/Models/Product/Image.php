<?php
/* */

namespace InnoShop\Common\Models\Product;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Product;

class Image extends BaseModel
{
    protected $table = 'product_images';

    protected $fillable = ['path', 'is_cover', 'belong_sku', 'position'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
