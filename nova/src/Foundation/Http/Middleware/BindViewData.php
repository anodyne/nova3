<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class BindViewData {

	public function handle($request, Closure $next)
	{
		view()->share('_page', 
			app('PageRepository')->getByRoute(app('request')->route())
		);
		view()->share('_icons', false);
		view()->share('_currentUser', app('nova.user'));

		return $next($request);
	}

}
