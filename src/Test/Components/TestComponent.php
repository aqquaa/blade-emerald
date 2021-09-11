<?php

namespace Aqua\Emerald\Test\Components;

use Illuminate\View\Component;
use Aqua\Emerald\Traits\Markup;

class Testcomponent extends Component
{
    use Markup;

    public $wrap;

    public function __construct($wrap)
    {
        $this->wrap = $wrap;
    }

    public function render()
    {
        return view('emeraldtest::testcomponent');
    }
}
