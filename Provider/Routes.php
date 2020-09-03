<?php

namespace BeetleCore\Provider;

use Illuminate\Support\ServiceProvider;

class Routes extends ServiceProvider
{
	public function boot()
	{
		app("router")->aliasMiddleware("beetle-authenticate", \BeetleCore\Middleware\Authenticate::class);
		include __DIR__ . '/../routes/web.php';
	}
}