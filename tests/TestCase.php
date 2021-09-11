<?php

namespace Aqua\Emerald\Tests;

use Aqua\Emerald\EmeraldServiceProvider;
use Aqua\Emerald\Test\TestEmeraldServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class TestCase extends TestbenchTestCase
{
    use InteractsWithViews;

    protected function getPackageProviders($app)
    {
        return [
            EmeraldServiceProvider::class,
            TestEmeraldServiceProvider::class,
        ];
    }
}
