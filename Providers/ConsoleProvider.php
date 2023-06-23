<?php


namespace BeetleCore\Providers;

use BeetleCore\Console\Commands\MakeCommand;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ConsoleProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCommand::class,
            ]);
        }
    }
}
