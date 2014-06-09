<?php namespace Nova\Aegis\Sessions;

interface SessionInterface {

	public function put($value);

	public function get();

	public function forget();

}