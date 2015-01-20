<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class Installed {

	public function handle($request, Closure $next)
	{
		return $next($request);
	}

}