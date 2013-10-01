<?php namespace Nova\Core\Lib;

use Setup;
use Sentry;
use Session;
use NovaAuthInterface;

class Auth implements NovaAuthInterface {

	public function __construct()
	{
		$this->installed = Setup::installed(false);
	}

	public function authenticateAndRemember(array $credentials)
	{
		return Sentry::authenticateAndRemember($credentials);
	}

	public function check()
	{
		if (is_bool($this->installed) and $this->installed)
			return Sentry::check();

		return false;
	}

	public function getCookie()
	{
		return Sentry::getCookie()->getCookie();
	}

	public function getThrottleProvider()
	{
		return Sentry::getThrottleProvider();
	}

	public function getUser()
	{
		if (is_bool($this->installed) and $this->installed)
			return Sentry::getUser();

		return false;
	}

	public function getUserProvider()
	{
		return Sentry::getUserProvider();
	}

	public function logout()
	{
		// Do the logout
		Sentry::logout();

		// Flush the session for safe measure
		Session::flush();
	}

}