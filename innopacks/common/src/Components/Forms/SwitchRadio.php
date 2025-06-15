<?php
/* */

namespace InnoShop\Common\Components\Forms;

use Illuminate\View\Component;

class SwitchRadio extends Component
{
    public string $name;

    public bool $value;

    public string $title;

    public function __construct(string $name, ?bool $value, string $title)
    {
        $this->name  = $name;
        $this->title = $title;
        $this->value = (bool) $value;
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('common::components.form.switch-radio');
    }
}
