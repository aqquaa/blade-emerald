<?php

namespace Aqua\Emerald\Tests\Setup\Components;

use Illuminate\View\Component;
use Aqua\Emerald\Traits\Markup;

class TestComponentCustomWrapProp extends Component
{
    use Markup;

    protected static $wrapby = 'markup';

    public $markup;

    public function __construct($markup)
    {
        $this->markup = $markup;
    }

    public function render()
    {
        return view('emeraldtest::testcomponent');
    }
}
