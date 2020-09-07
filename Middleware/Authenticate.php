<?php


namespace BeetleCore\Middleware;

use Illuminate\Http\Request;

class Authenticate
{
	public function handle(Request $request, \Closure $next)
	{
		if (!empty($request->get("system__enter_to_admin"))) {
			$user = \BeetleCore\Models\UserAdmin::auth($request->get("login"), $request->get("password"));
			$request->session()->put("admin", $user);
			return redirect($request->fullUrl());
		}

		if (!empty($request->session()->get("admin"))) {
			return $next($request);
		} else {
			return response()->view("beetlecore::login");
		}
	}
}