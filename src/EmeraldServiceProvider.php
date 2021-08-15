<?php

namespace Aqua\Emerald;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Aqua\Emerald\Components\Emerald;

class EmeraldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'emerald');

        $this->loadViewComponentsAs('emerald', [
            Emerald::class,
        ]);

        Blade::component('emerald', Emerald::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
