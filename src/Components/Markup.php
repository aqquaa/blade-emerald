<?php

namespace Aqua\Emerald\Components;

use Illuminate\View\Component;
use Spatie\HtmlElement\HtmlElement;

class Markup extends Component
{
    public $make;

    public function __construct($make) { $this->make = $make; }

    public function getMarkup($content) {
        return HtmlElement::render($this->make, $content);
    }

    public function render()
    {
        return view('emerald::components.emerald');
    }
}
