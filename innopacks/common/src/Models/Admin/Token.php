<?php
/* */

namespace InnoShop\Common\Models\Admin;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\Admin;
use InnoShop\Common\Models\BaseModel;

class Token extends BaseModel
{
    protected $table = 'admin_tokens';

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
