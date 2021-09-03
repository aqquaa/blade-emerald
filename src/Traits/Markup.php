<?php

namespace Aqua\Emerald\Traits;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View as ViewContract;
use Aqua\Emerald\Generate;

trait Markup {
    public function resolveView()
    {
        throw_if(
            ! property_exists(static::class, 'markify') || empty(static::$markify),
            new \InvalidArgumentException('Blade-Emerald parse error: missing "markify" property')
        );

        $view = (new Generate)->generateMarkup($this->{static::$markify}, ($this->render())->render());

        
        if ($view instanceof ViewContract) {
            return $view;
        }

        if ($view instanceof Htmlable) {
            return $view;
        }

        $resolver = function ($view) {
            $factory = Container::getInstance()->make('view');

            return $factory->exists($view)
                        ? $view
                        : $this->createBladeViewFromString($factory, $view);
        };

        return $view instanceof Closure ? function (array $data = []) use ($view, $resolver) {
            return $resolver($view($data));
        }
        : $resolver($view);
    }
}