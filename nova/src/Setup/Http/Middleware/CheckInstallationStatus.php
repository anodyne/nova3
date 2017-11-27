<?php namespace Nova\Setup\Http\Middleware;

use Closure;

class CheckInstallationStatus
{
	/**
	 * Check to see if Nova is installed. If it isn't installed, redirect to
	 * the environment check page which will kick off the setup process.
	 */
	public function handle($request, Closure $next)
	{
		if (! nova()->isInstalled()) {
			return redirect()->route('setup.env');
		}
		
		return $next($request);
	}
}
