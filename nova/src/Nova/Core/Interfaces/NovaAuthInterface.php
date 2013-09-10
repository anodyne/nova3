<?php namespace Nova\Core\Interfaces;

interface NovaAuthInterface {
	
	public function authenticateAndRemember(array $credentials);

	public function check();

	public function getCookie();

	public function getThrottleProvider();

	public function getUser();

	public function getUserProvider();

	public function logout();

}