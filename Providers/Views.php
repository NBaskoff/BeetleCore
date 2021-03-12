<?php


namespace BeetleCore\Providers;

use Illuminate\Support\ServiceProvider;

class Views extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . "/../resources/views", "beetlecore");
        //view()->share("beetleCoreResourcesFolder", "/resources");
        view()->share("beetleCoreResourcesFolder", "//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1.9.7/resources");
    }
}
