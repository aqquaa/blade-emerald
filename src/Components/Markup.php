<?php

namespace Aqua\Emerald\Components;

use Illuminate\View\Component;
use Aqua\Emerald\Generate;

class Markup extends Component
{
    public $make;

    public function __construct($make) { $this->make = $make; }

    public function getMarkup($content) {
        return (new Generate)->generateMarkup($this->make, $content);
    }

    public function render()
    {
        return view('emerald::components.emerald');
    }
}
