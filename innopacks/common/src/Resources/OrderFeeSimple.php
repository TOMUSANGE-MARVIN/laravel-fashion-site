<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderFeeSimple extends JsonResource
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
            'id'           => $this->id,
            'order_id'     => $this->order_id,
            'code'         => $this->code,
            'value'        => $this->value,
            'title'        => $this->title,
            'reference'    => $this->reference,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'value_format' => $this->value_format,
        ];
    }
}
