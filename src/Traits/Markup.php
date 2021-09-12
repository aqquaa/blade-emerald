<?php

namespace Aqua\Emerald\Traits;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View as ViewContract;
use Spatie\HtmlElement\HtmlElement;

trait Markup {
    public function resolveView()
    {
        $abbreviation = $this->extractEmeraldAbbr();

        $renderedContent = is_string($this->render()) ? $this->render() : ($this->render())->render();
        $view = HtmlElement::render($abbreviation, $renderedContent);

        $resolver = function ($view) {
            $factory = Container::getInstance()->make('view');

            return $factory->exists($view)
                        ? $view
                        : $this->createBladeViewFromString($factory, $view);
        };

        return $resolver($view);
    }

    protected function extractEmeraldAbbr() : string {
        if(! property_exists(static::class, 'wrapbby')) {
            try { return $this->wrap; } catch (\Exception $th) {
                // Blade-Emerald parse error: either accept abbreviation using `wrap` property or define your property name using `wrapby` property
            }
        }

        try { return $this->{static::$wrapby}; } catch (\Exception $th) {
            throw new \InvalidArgumentException("Blade-Emerald parse error: unable to extract abbreviation using `{static::$wrapby}` property");
        }

        return '';
    }
}
