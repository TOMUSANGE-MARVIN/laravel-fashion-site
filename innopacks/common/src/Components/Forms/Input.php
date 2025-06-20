<?php
/* */

namespace InnoShop\Common\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    public string $name;

    public string $title;

    public string $error;

    public string $placeholder;

    public string $description;

    public string $type;

    public bool $required;

    public bool $disabled;

    public bool $readonly;

    public mixed $value;

    public bool $multiple;

    public string $column;

    public bool $generate;

    public bool $translate;

    public function __construct(string $name, string $title, $value = null, bool $required = false, string $error = '',
        string $type = 'text', string $placeholder = '', string $description = '', bool $disabled = false, bool $readonly = false,
        bool $multiple = false, string $column = '', bool $generate = false, bool $translate = false)
    {
        if (! $multiple) {
            $value = html_entity_decode($value, ENT_QUOTES);
        }

        $this->name        = $name;
        $this->title       = $title;
        $this->value       = $value;
        $this->error       = $error;
        $this->placeholder = $placeholder;
        $this->type        = $type;
        $this->required    = $required;
        $this->description = $description;
        $this->disabled    = $disabled;
        $this->readonly    = $readonly;
        $this->multiple    = $multiple;
        $this->column      = $column;
        $this->generate    = $generate;
        $this->translate   = $translate && has_translator();
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('common::components.form.input');
    }
}
