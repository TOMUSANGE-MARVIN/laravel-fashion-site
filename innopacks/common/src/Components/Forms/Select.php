<?php
/* */

namespace InnoShop\Common\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;

    public bool $required;

    public ?string $value;

    public string $title;

    public array $options;

    public string $key;

    public string $label;

    public bool $emptyOption;

    public function __construct(string $name, ?string $value, string $title, array $options, ?string $key = 'value', ?string $label = 'label', ?bool $required = false, ?bool $emptyOption = true)
    {
        $this->name        = $name;
        $this->value       = $value;
        $this->title       = $title;
        $this->options     = $options;
        $this->key         = $key;
        $this->label       = $label;
        $this->required    = $required;
        $this->emptyOption = $emptyOption;
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('common::components.form.select');
    }
}
