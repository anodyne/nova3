<?php namespace Nova\Core\Lib;

use Date;
use Setup;
use Sentry;
use Session;
use NovaAuthInterface;

class Auth implements NovaAuthInterface {

	public function __construct()
	{
		$this->installed = Setup::installed(false);
	}

	/**
	 * Authenticate a user and remember them forever.
	 *
	 * @param	array	$credentials	Credentials to use for authenticating
	 * @return	User
	 */
	public function authenticateAndRemember(array $credentials)
	{
		return Sentry::authenticateAndRemember($credentials);
	}

	/**
	 * Check if a user is logged in.
	 *
	 * @return	bool
	 */
	public function check()
	{
		if (is_bool($this->installed) and $this->installed)
			return Sentry::check();

		return false;
	}

	/**
	 * Get the cookie.
	 *
	 * @return	Cookie
	 */
	public function getCookie()
	{
		return Sentry::getCookie()->getCookie();
	}

	/**
	 * Get the remaining time of the log in suspension.
	 *
	 * @param	string	$email	Email address to check
	 * @return	string
	 */
	public function getSuspendedTimeRemaining($email)
	{
		// Get the throttle record
		$throttle = $this->getThrottleProvider()->findByLogin($email);

		// Get the suspended date into a usable format
		$suspendedAt = Date::instance($throttle->suspended_at)
			->addMinutes($throttle->getSuspensionTime());

		return $suspendedAt->diffInMinutes(Date::now('UTC'));
	}

	/**
	 * Get the throttle provider.
	 *
	 * @return	ThrottleProviderInterface
	 */
	public function getThrottleProvider()
	{
		return Sentry::getThrottleProvider();
	}

	/**
	 * Get the current user.
	 *
	 * @return	User
	 */
	public function getUser()
	{
		if (is_bool($this->installed) and $this->installed)
			return Sentry::getUser();

		return false;
	}

	/**
	 * Get the user provider.
	 *
	 * @return	UserProviderInterface
	 */
	public function getUserProvider()
	{
		return Sentry::getUserProvider();
	}

	/**
	 * Log out.
	 *
	 * @return	void
	 */
	public function logout()
	{
		// Do the logout
		Sentry::logout();

		// Flush the session for safe measure
		Session::flush();
	}

}