<?php namespace nova\extensions\cartalyst\sentry\hashing;

use System;
use Cartalyst\Sentry\Hashing\HasherInterface;

class NovaHasher implements HasherInterface {

	/**
	 * Salt Length
	 *
	 * @var int
	 */
	public $saltLength = 32;

	/**
	 * Hash string.
	 *
	 * @param	string	The string
	 * @return	string
	 */
	public function hash($string)
	{
		// Create salt
		$salt = $this->createSalt();

		return $salt.hash('sha256', $salt.$string);
	}

	/**
	 * Check string against hashed string.
	 *
	 * @param	string	The string
	 * @param	string	The hashed string
	 * @return	bool
	 */
	public function checkhash($string, $hashedString)
	{
		$salt = substr($hashedString, 0, $this->saltLength);

		return ($salt.hash('sha256', $salt.$string)) === $hashedString;
	}

	/**
	 * Use the system UID as the password salt.
	 *
	 * @return	string
	 */
	protected function createSalt()
	{
		return System::getUniqueId();
	}
	
}