<?php
/* */

namespace InnoShop\Common\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartListItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     * @throws \Exception
     */
    public function toArray(Request $request): array
    {
        $sku        = $this->productSku;
        $product    = $this->product;
        $subtotal   = $this->subtotal;
        $finalPrice = $sku->getFinalPrice();

        $data = [
            'data' => [
                'id'                  => $this->id,
                'quantity'            => $this->quantity,
                'product_id'          => $product->id,
                'product_name'        => $product->translation->name ?? '',
                'variant_label'       => $sku->variant_label,
                'tax_class_id'        => $product->tax_class_id,
                'sku_id'              => $sku->id,
                'sku_code'            => $sku->code,
                'is_virtual'          => $product->is_virtual,
                'weight'              => $product->weight,
                'price'               => $finalPrice,
                'price_format'        => currency_format($finalPrice),
                'origin_price'        => $sku->origin_price,
                'origin_price_format' => $sku->origin_price_format,
                'subtotal'            => $subtotal,
                'subtotal_format'     => currency_format($subtotal),
                'image'               => $sku->getImageUrl(),
                'url'                 => $product->url,
                'selected'            => (bool) $this->selected,
            ],
            'cart' => $this,
        ];
        $data = fire_hook_filter('resource.cart_list_item', $data);

        return $data['data'];
    }
}
