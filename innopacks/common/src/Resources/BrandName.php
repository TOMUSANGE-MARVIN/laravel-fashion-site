<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandName extends JsonResource
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
            'id'     => $this->id,
            'slug'   => $this->slug,
            'name'   => $this->name,
            'active' => (bool) $this->active,
        ];
    }
}
