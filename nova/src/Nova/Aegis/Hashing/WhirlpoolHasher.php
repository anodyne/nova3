<?php namespace Nova\Aegis\Hashing;

class WhirlpoolHasher implements HasherInterface {

	use HasherTrait;

	public function hash($value)
	{
		$salt = $this->createSalt();

		return $salt.hash('whirlpool', $salt.$value);
	}

	public function check($value, $hashedValue)
	{
		$salt = substr($hashedValue, 0, $this->saltLength);

		return $this->slowEquals($salt.hash('whirlpool', $salt.$value), $hashedValue);
	}

}