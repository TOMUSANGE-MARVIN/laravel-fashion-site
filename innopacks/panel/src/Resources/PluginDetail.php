<?php
/* */

namespace InnoShop\Panel\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PluginDetail extends JsonResource
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
        return [
            'code'        => $this->getCode(),
            'name'        => $this->getLocaleName(),
            'description' => $this->getLocaleDescription(),
            'path'        => $this->getPath(),
            'version'     => $this->getVersion(),
            'dir_name'    => $this->getDirName(),
            'type'        => $this->getType(),
            'type_format' => panel_trans('plugin.'.$this->getType()),
            'icon'        => plugin_resize($this->getCode(), $this->getIcon()),
            'author'      => $this->getAuthor(),
            'active'      => $this->checkActive(),
            'installed'   => $this->checkInstalled(),
            'edit_url'    => $this->getEditUrl(),
        ];
    }
}
