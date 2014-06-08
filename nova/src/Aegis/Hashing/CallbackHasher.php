<?php namespace Nova\Aegis\Hashing;

use Closure;

class CallbackHasher implements HasherInterface {

	protected $hash;

	protected $check;

	public function __construct(Closure $hash, Closure $check)
	{
		$this->hash = $hash;
		$this->check = $check;
	}

	public function hash($value)
	{
		$callback = $this->hash;

		return $callback($value);
	}

	public function check($value, $hashedValue)
	{
		$callback = $this->check;

		return $callback($value, $hashedValue);
	}

}