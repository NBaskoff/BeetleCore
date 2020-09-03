<?php


namespace BeetleCore\Provider;


class Routes
{
	public function boot()
	{
		include __DIR__.'/../routes/web.php';
	}
}