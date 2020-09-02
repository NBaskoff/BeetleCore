<?php


namespace BeetleCore\Provider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class Migrations extends ServiceProvider
{
	public function boot()
	{
		Schema::defaultStringLength(191);
		$this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
		$this->loadViewsFrom(__DIR__ . "/../resources/views", "beetlecore");
		app("router")->aliasMiddleware("beetle-authenticate", \BeetleCore\Middleware\Authenticate::class);
	}
}