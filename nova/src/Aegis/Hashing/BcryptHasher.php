<?php namespace Nova\Aegis\Hashing;

class BcryptHasher implements HasherInterface {

	use HasherTrait;

	public $strength = 8;

	public function hash($value)
	{
		$salt = $this->createSalt();

		// Format strength
		$strength = str_pad($this->strength, 2, '0', STR_PAD_LEFT);

		// Create prefix - "$2y$"" fixes blowfish weakness
		$prefix = PHP_VERSION_ID < 50307 ? '$2a$' : '$2y$';

		return crypt($value, $prefix.$strength.'$'.$salt.'$');
	}

	public function check($value, $hashedValue)
	{
		return $this->slowEquals(crypt($value, $hashedValue), $hashedValue);
	}

}