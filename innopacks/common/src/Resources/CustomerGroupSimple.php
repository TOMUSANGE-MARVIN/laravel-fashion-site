<?php
/* */

namespace InnoShop\Common\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerGroupSimple extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->fallbackName(),
        ];
    }
}
