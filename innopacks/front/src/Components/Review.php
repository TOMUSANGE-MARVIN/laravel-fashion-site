<?php
/* */

namespace InnoShop\Front\Components;

use Illuminate\View\Component;

class Review extends Component
{
    public int $rating;

    /**
     * @param  $rating
     */
    public function __construct($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        return view('components.review');
    }
}
