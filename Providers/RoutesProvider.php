<?php

namespace BeetleCore\Providers;

use Illuminate\Support\ServiceProvider;

class RoutesProvider extends ServiceProvider
{
    public function boot()
    {
        app("router")->aliasMiddleware("beetle-authenticate", \BeetleCore\Middleware\Authenticate::class);
        include __DIR__ . '/../routes/api.php';
        include __DIR__ . '/../routes/channels.php';
        include __DIR__ . '/../routes/console.php';
        include __DIR__ . '/../routes/web.php';
    }
}
