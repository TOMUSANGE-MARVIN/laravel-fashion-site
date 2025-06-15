<?php
/* */

namespace InnoShop\Common\Models\Order;

use Exception;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Services\StateMachineService;

class History extends BaseModel
{
    protected $table = 'order_histories';

    protected $fillable = [
        'order_id', 'status', 'notify', 'comment',
    ];

    /**
     * @return string
     * @throws Exception
     */
    public function getStatusFormatAttribute(): string
    {
        $statusCode = $this->status;
        if ($statusCode == null) {
            return '';
        }

        $statusMap = array_column(StateMachineService::getAllStatuses(), 'name', 'status');

        return $statusMap[$statusCode] ?? '';
    }
}
