<?php
/* */

namespace InnoShop\Plugin\Resources\Checkout;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoShop\Plugin\Resources\PluginResource;

class ShippingMethodItem extends JsonResource
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
        $pluginResource = (new PluginResource($this->plugin))->jsonSerialize();

        return [
            'type'        => $pluginResource['type'],
            'code'        => $pluginResource['code'],
            'name'        => $pluginResource['name'],
            'description' => $pluginResource['description'],
            'icon'        => $pluginResource['icon'],
        ];
    }
}
