<?php

namespace Aqua\Emerald\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Aqua\Emerald\EmeraldServiceProvider;
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
}
