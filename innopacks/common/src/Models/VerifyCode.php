<?php
/* */

namespace InnoShop\Common\Models;

class VerifyCode extends BaseModel
{
    protected $table = 'verify_codes';

    protected $fillable = [
        'account', 'code', 'deleted_at',
    ];
}
