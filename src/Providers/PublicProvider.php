<?php


namespace BeetleCore\Providers;

use BeetleCore\Console\Commands\MakeCommand;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class PublicProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../public/public' => public_path("/"),
            __DIR__ . '/../../public/BeetleCMS' => app_path("BeetleCMS"),
            __DIR__ . '/../../public/routes' => base_path("routes"),
            __DIR__.'/../resources/views/menu.blade.php' => resource_path('views/vendor/beetlecore/menu.blade.php'),
        ], "beetlecore-start");
    }
}
