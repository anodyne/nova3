<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class Installed {

	public function handle($request, Closure $next)
	{
		if ( ! app('cache')->get('nova.installed'))
		{
			return redirect()->route('setup.env');
		}

		return $next($request);
	}

}
