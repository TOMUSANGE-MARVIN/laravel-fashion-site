<?php
/* */

namespace InnoShop\Common\Components\Forms;

use Illuminate\View\Component;

class Images extends Component
{
    public string $name;

    public string $title;

    public string $type;

    public array $values;

    public int $max;

    public function __construct(string $name, ?string $title, int $max = 0, string $type = 'common', $values = [])
    {
        $this->name   = $name;
        $this->values = $values;
        $this->max    = $max;
        $this->type   = $type;
        $this->title  = $title ?? '';
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('common::components.form.images');
    }
}
