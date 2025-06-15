<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderHistory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     * @throws Exception
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'status'        => $this->status,
            'status_format' => $this->status_format,
            'notify'        => $this->notify,
            'comment'       => $this->comment,
            'created_at'    => $this->created_at,
        ];
    }
}
