<?php
/* */

namespace InnoShop\Common\Components\Forms;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $name;

    public string $title;

    public bool $required;

    public mixed $value;

    public bool $multiple;

    public string $column;

    public bool $generate;

    public bool $translate;

    public function __construct(string $name, string $title, $value = null, bool $required = false, bool $multiple = false,
        string $column = '', bool $generate = false, bool $translate = false)
    {
        if (! $multiple) {
            $value = html_entity_decode($value, ENT_QUOTES);
        }

        $this->name      = $name;
        $this->title     = $title;
        $this->value     = $value;
        $this->required  = $required;
        $this->multiple  = $multiple;
        $this->column    = $column;
        $this->generate  = $generate;
        $this->translate = $translate && has_translator();
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('common::components.form.textarea');
    }
}
