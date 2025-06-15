<?php
/* */

namespace InnoShop\Panel\Components\Data;

use Illuminate\View\Component;

class Criteria extends Component
{
    public string $action;

    public array $criteria;

    /**
     * Types: [input, select, date, range, date_range]
     *
     * @param  string  $action
     * @param  array  $criteria
     */
    public function __construct(string $action, array $criteria)
    {
        $this->action   = $action;
        $this->criteria = $criteria;
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('panel::components.data.criteria');
    }
}
