<?php namespace Nova\Aegis;

interface AuthenticationInterface {

	public function check();
	public function login(array $credentials, $remember = true);
	public function logout();
	public function user();
	public function validate(array $credentials);

}