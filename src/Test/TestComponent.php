<?php

namespace Aqua\Emerald\Test;

class TestComponent
{
    /**
     * The original component.
     *
     * @var \Illuminate\View\Component
     */
    public $component;

    /**
     * The rendered component contents.
     *
     * @var string
     */
    protected $rendered;

    /**
     * Create a new test component instance.
     *
     * @param  \Illuminate\View\Component  $component
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function __construct($component, $view)
    {
        $this->component = $component;

        $this->rendered = $view->render();
    }

    /**
     * Get the string contents of the rendered component.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->rendered;
    }

    /**
     * Dynamically access properties on the underlying component.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->component->{$attribute};
    }

    /**
     * Dynamically call methods on the underlying component.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->component->{$method}(...$parameters);
    }
}
