<?php
/* */

namespace InnoShop\Common\Components\Base;

use Illuminate\View\Component;

class NoData extends Component
{
    public string $text;

    public string $width;

    public function __construct(?string $text = '', ?string $width = '300')
    {
        $this->text  = $text;
        $this->width = $width;
    }

    public function render()
    {
        return view('common::components.no-data');
    }
}
