<?php
/* */

namespace InnoShop\Panel\Components\Forms;

use Illuminate\View\Component;

class Codemirror extends Component
{
    public string $name;

    public string $value;

    public function __construct(string $name, ?string $value)
    {
        $this->name  = $name;
        $this->value = html_entity_decode($value, ENT_QUOTES);
    }

    public function render()
    {
        return view('panel::components.form.codemirror');
    }
}
