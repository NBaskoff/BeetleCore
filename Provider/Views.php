<?php


namespace BeetleCore\Provider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class Views extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . "/../resources/views", "beetlecore");
	}
}