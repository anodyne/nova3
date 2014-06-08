<?php namespace Nova\Aegis\Cookies;

interface CookieInterface {

	public function put($value);

	public function get();

	public function forget();

}