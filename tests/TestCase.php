<?php

namespace Aqua\Emerald\Tests;

use Aqua\Emerald\EmeraldServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Aqua\Emerald\Tests\Setup\{ TestEmeraldServiceProvider, InteractsWithViews };

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
