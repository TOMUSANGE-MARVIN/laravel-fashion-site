<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteItem extends JsonResource
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
        $product = $this->product;
        $sku     = $product->masterSku;
        if (empty($sku)) {
            throw new Exception('Empty SKU for '.$this->id);
        }

        return [
            'id'                  => $this->id,
            'sku_id'              => $sku->id,
            'product_id'          => $product->id,
            'slug'                => $product->slug,
            'url'                 => $product->url,
            'name'                => $product->translation->name,
            'summary'             => $product->translation->summary,
            'image_small'         => $sku->getImageUrl(),
            'image_big'           => $sku->getImageUrl(600, 600),
            'price_format'        => $sku->price_format,
            'origin_price_format' => $sku->origin_price_format,
        ];
    }
}
