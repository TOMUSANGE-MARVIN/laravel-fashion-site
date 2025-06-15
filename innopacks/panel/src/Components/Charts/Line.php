<?php
/* */

namespace InnoShop\Panel\Components\Charts;

use Illuminate\View\Component;

class Line extends Component
{
    public string $id;

    public string $title;

    public array $labels;

    public array $items;

    /**
     * @param  string  $id
     * @param  string  $title
     * @param  array  $labels
     * @param  array  $data
     */
    public function __construct(string $id, string $title, array $labels, array $data)
    {
        $this->id     = $id;
        $this->title  = $title;
        $this->labels = $labels;
        $this->items  = $data;
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('panel::components.charts.line');
    }
}
