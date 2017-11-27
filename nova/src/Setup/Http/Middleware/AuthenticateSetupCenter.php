<?php namespace Nova\Setup\Http\Middleware;

use Closure;
use Nova\Foundation\SystemInfo;

class AuthenticateSetupCenter
{
	/**
	 * Check to see if Nova is installed. If it isn't installed, redirect to
	 * the environment check page which will kick off the setup process.
	 */
	public function handle($request, Closure $next)
	{
		if (nova()->isInstalled()) {
			// Grab the system info record
			$sysinfo = SystemInfo::first();

			// If we're still in phase 1, keep going
			if ($sysinfo->install_phase < 2 and $sysinfo->migrate_phase < 2) {
				return $next($request);
			}

			// The user isn't signed in
			if (! auth()->check()) {
				return redirect()->route('sign-in');
			}

			if (auth()->user()->cannot('system.update')) {
				return redirect()->route('setup.error', 200);
			}
		}

		return $next($request);
	}
}
