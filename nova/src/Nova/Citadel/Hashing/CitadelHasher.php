<?php
/**
 * Citadel Hasher.
 *
 * This is nearly identical to the Sentry SHA256 hasher except that the salt we
 * create is based off the system UID generated during install.
 *
 * @package		Nova
 * @subpackage	Citadel
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

namespace Nova\Citadel\Hashing;

use Cartalyst\Sentry\Hashing\HasherInterface as SentryHashInterface;

class CitadelHasher implements SentryHashInterface {

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
		return SystemModel::getUid();
	}
}
