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
    }
}
