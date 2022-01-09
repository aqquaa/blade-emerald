<?php

namespace Aqua\Emerald\Tests;

use Illuminate\Support\Facades\Blade;
use Aqua\Emerald\EmeraldServiceProvider;
use Aqua\Emerald\Tests\Setup\Components\TestComponent;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Aqua\Emerald\Tests\Setup\Components\TestComponentCustomWrapProp;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class TestCase extends TestbenchTestCase
{
    use InteractsWithViews;

    protected function getPackageProviders($app)
    {
        return [
            EmeraldServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Blade::component('test-component', TestComponent::class);
        Blade::component('test-component-custom-wrap-prop', TestComponentCustomWrapProp::class);
    }
        

    protected function defineEnvironment($app)
    {
        $app['config']->set('view.paths', [
            __DIR__.'/Setup/views',
            resource_path('views'),
        ]);
    }
}
