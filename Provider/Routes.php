<?php

namespace BeetleCore\Provider;

use Illuminate\Support\ServiceProvider;

class Routes extends ServiceProvider
{
	public function boot()
	{
		include __DIR__ . '/../routes/web.php';
	}
}