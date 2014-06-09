<?php namespace Nova\Aegis\Hashing;

interface HasherInterface {

	public function hash($value);

	public function check($value, $hashedValue);

}