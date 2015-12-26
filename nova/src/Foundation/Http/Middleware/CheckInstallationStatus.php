<?php namespace Nova\Foundation\Http\Middleware;

use Closure;

class CheckInstallationStatus {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ( ! app('nova.setup')->isInstalled())
		{
			return redirect()->route('setup.env');
		}
		
		return $next($request);
	}

}
