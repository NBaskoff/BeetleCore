<?php

namespace BeetleCore\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use BeetleCore\Middlewares\AuthenticateMiddleware;

class RoutesProvider extends ServiceProvider
{
    public function boot()
    {
        $this->aliasMiddleware("beetle-authenticate", AuthenticateMiddleware::class);
        $path = base_path("routes/admin.php");
        if (file_exists($path)) {
            $this->routes(function () use ($path) {
                Route::middleware('web')
                    ->group($path);
            });
        }
    }
}
