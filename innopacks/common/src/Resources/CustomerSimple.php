<?php
/* */

namespace InnoShop\Common\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerSimple extends JsonResource
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
            'email'        => $this->email,
            'name'         => $this->name,
            'avatar'       => image_resize($this->avatar),
            'locale'       => $this->locale,
            'has_password' => $this->has_password,
        ];
    }
}
