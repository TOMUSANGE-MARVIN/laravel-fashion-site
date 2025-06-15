<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemSimple extends JsonResource
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
            'order_id'        => $this->order_id,
            'product_id'      => $this->product_id,
            'order_number'    => $this->order_number,
            'product_sku'     => $this->product_sku,
            'variant_label'   => $this->variant_label,
            'name'            => $this->name,
            'image'           => $this->image,
            'quantity'        => $this->quantity,
            'price'           => $this->price,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'deleted_at'      => $this->deleted_at,
            'subtotal'        => $this->subtotal,
            'price_format'    => $this->price_format,
            'subtotal_format' => $this->subtotal_format,
            'has_review'      => $this->has_review,
        ];
    }
}
