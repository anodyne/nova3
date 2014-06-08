<?php namespace Nova\Aegis\Hashing;

class NativeHasher implements HasherInterface {

	public function hash($value)
	{
		if ( ! $hash = password_hash($value, PASSWORD_DEFAULT))
		{
			throw new \RuntimeException('Error hashing value. Check system compatibility with password_hash().');
		}

		return $hash;
	}

	public function check($value, $hashedValue)
	{
		return password_verify($value, $hashedValue);
	}

}