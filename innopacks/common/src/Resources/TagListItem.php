<?php
/* */

namespace InnoShop\Common\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagListItem extends JsonResource
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
            'id'       => $this->id,
            'slug'     => $this->slug,
            'name'     => $this->translation->name ?? '',
            'position' => $this->position,
            'active'   => (bool) $this->active,
        ];
    }
}
