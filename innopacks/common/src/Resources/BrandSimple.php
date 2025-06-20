<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandSimple extends JsonResource
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
            'id'       => $this->id,
            'first'    => $this->first,
            'name'     => $this->name,
            'slug'     => $this->slug,
            'logo_url' => image_resize($this->logo),
            'active'   => (bool) $this->active,
        ];
    }
}
