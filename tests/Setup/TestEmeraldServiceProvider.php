<?php

namespace Aqua\Emerald\Tests\Setup;

use Illuminate\Support\ServiceProvider;
use Aqua\Emerald\Tests\Setup\Components\{ TestComponent, TestComponentCustomWrapProp };

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
