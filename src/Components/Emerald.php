<?php

namespace Aqua\Emerald\Components;

use Illuminate\View\Component;

class Emerald extends Component
{
    public $make;

    public function __construct($make) {
        $this->make = $make;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('emerald::components.emerald');
    }
}
