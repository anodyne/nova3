<?php namespace Nova\Core\Interfaces;

interface NovaAuthInterface {
	
	/**
	 * Authenticate a user and remember them forever.
	 *
	 * @param	array	$credentials	Credentials to use for authenticating
	 * @return	User
	 */
	public function authenticateAndRemember(array $credentials);

	/**
	 * Check if a user is logged in.
	 *
	 * @return	bool
	 */
	public function check();

	/**
	 * Get the cookie.
	 *
	 * @return	Cookie
	 */
	public function getCookie();

	/**
	 * Get the remaining time of the log in suspension.
	 *
	 * @param	string	$email	Email address to check
	 * @return	string
	 */
	public function getSuspendedTimeRemaining($email);

	/**
	 * Get the throttle provider.
	 *
	 * @return	ThrottleProviderInterface
	 */
	public function getThrottleProvider();

	/**
	 * Get the current user.
	 *
	 * @return	User
	 */
	public function getUser();

	/**
	 * Get the user provider.
	 *
	 * @return	UserProviderInterface
	 */
	public function getUserProvider();

	/**
	 * Log out.
	 *
	 * @return	void
	 */
	public function logout();

}