<?php

namespace Aqua\Emerald\Test;

use Illuminate\Support\ServiceProvider;
use Aqua\Emerald\Test\Components\{ TestComponent, TestComponentCustomWrapProp };

class TestEmeraldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'emeraldtest');

        $this->loadViewComponentsAs('emeraldtest', [
            TestComponent::class,
            TestComponentCustomWrapProp::class,
        ]);
    }

    public function register() { }
}
