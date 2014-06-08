<?php namespace Nova\Aegis\Hashing;

trait HasherTrait {

	protected $saltLength = 22;

	protected function createSalt()
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle(str_repeat($pool, 5)), 0, $this->saltLength);
	}

	protected function slowEquals($a, $b)
	{
		$diff = strlen($a) ^ strlen($b);

		for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
		{
			$diff |= ord($a[$i]) ^ ord($b[$i]);
		}

		return $diff === 0;
	}

}