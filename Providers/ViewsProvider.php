<?php


namespace BeetleCore\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ViewsProvider extends ServiceProvider
{
    public function boot()
    {
        Paginator::useBootstrap();
        $this->loadViewsFrom(__DIR__ . "/../resources/views", "beetlecore");
        //view()->share("beetleCoreResourcesFolder", "/resources");
        view()->share("beetleCoreResourcesFolder", "//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1.9.13/resources");
    }
}
