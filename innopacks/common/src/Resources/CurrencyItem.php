<?php
/* */

namespace InnoShop\Common\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyItem extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'symbol_left'   => $this->symbol_left,
            'symbol_right'  => $this->symbol_right,
            'decimal_place' => $this->decimal_place,
            'value'         => $this->value,
            'active'        => $this->active,
        ];
    }
}
