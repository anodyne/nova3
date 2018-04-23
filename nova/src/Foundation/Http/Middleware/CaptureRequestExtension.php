<?php namespace Nova\Foundation\Http\Middleware;

class CaptureRequestExtension
{
	public function handle($request, $next)
	{
		if ($request->route()->parameter('_extension') !== null) {
			$request->attributes->set('_extension', substr($request->route()->parameter('_extension'), 1));
			$request->route()->forgetParameter('_extension');
		}

		return $next($request);
	}
}
