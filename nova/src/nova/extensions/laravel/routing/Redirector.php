<?php namespace Nova\Extensions\Laravel\Routing;

use Nova\Extensions\Http\RedirectResponse;
use Illuminate\Routing\Redirector as LaravelRedirector;

class Redirector extends LaravelRedirector {

	/**
	 * Create a new redirect response.
	 *
	 * @param  string  $path
	 * @param  int     $status
	 * @param  array   $headers
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function createRedirect($path, $status, $headers)
	{
		$redirect = new RedirectResponse($path, $status, $headers);

		if (isset($this->session))
		{
			$redirect->setSession($this->session);
		}

		$redirect->setRequest($this->generator->getRequest());

		return $redirect;
	}

}