<?php namespace Nova\Aegis;

interface AuthorizationInterface {

	public function ability($roles, $permissions, $options = []);
	public function can($permission);
	public function hasRole($roleName);

}