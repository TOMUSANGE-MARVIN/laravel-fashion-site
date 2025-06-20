<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderShipment extends JsonResource
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
            'id'              => $this->id,
            'express_code'    => $this->express_code,
            'express_company' => $this->express_company,
            'express_number'  => $this->express_number,
            'created_at'      => $this->created_at,
        ];
    }
}
