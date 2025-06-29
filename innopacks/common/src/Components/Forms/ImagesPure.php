<?php
/* */

namespace InnoShop\Common\Components\Forms;

use Illuminate\View\Component;

class ImagesPure extends Component
{
    public string $name;

    public string $title;

    public string $type;

    public array $values;

    public string $description;

    public int $max;

    public function __construct(string $name, ?string $title, ?array $values = [], ?string $description = '', string $type = 'common', int $max = 0)
    {
        $this->name        = $name;
        $this->title       = $title       ?? '';
        $this->values      = $values      ?? [];
        $this->description = $description ?? '';
        $this->type        = $type;
        $this->max         = $max;
    }

    public function render()
    {
        return view('common::components.form.imagesp');
    }
}
