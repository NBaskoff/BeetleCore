<?php


namespace BeetleCore\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MigrationsProvider extends ServiceProvider
{
	public function boot()
	{
		//Schema::defaultStringLength(191);
		$this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
	}
}
