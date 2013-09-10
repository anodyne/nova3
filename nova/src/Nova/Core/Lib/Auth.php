<?php namespace Nova\Core\Lib;

use Sentry;
use Session;
use NovaAuthInterface;

class Auth implements NovaAuthInterface {

	public function authenticateAndRemember(array $credentials)
	{
		return Sentry::authenticateAndRemember($credentials);
	}

	public function check()
	{
		return Sentry::check();
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
		return Sentry::getUser();
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