<?php

namespace Aqua\Emerald\Tests\Setup;

use Illuminate\Support\Traits\Macroable;
use Illuminate\View\View;

class TestView
{
    use Macroable;

    /**
     * The original view.
     *
     * @var \Illuminate\View\View
     */
    protected $view;

    /**
     * The rendered view contents.
     *
     * @var string
     */
    protected $rendered;

    /**
     * Create a new test view instance.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function __construct(View $view)
    {
        $this->view = $view;
        $this->rendered = $view->render();
    }

    /**
     * Get the string contents of the rendered view.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->rendered;
    }
}
