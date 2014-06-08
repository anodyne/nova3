<?php namespace Nova\Aegis\Hashing;

class Sha256Hasher implements HasherInterface {

	use HasherTrait;

	public function hash($value)
	{
		$salt = $this->createSalt();

		return $salt.hash('sha256', $salt.$value);
	}

	public function check($value, $hashedValue)
	{
		$salt = substr($hashedValue, 0, $this->saltLength);

		return $this->slowEquals($salt.hash('sha256', $salt.$value), $hashedValue);
	}

}