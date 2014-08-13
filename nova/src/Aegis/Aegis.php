<?php namespace Nova\Aegis;

use Illuminate\Auth\Guard as Auth;

class Aegis implements AuthenticationInterface, AuthorizationInterface {

	protected $auth;

	public function __construct(Auth $auth)
	{
		$this->auth = $auth;
	}

	public function check()
	{
		return $this->auth->check();
	}

	public function login(array $credentials, $remember = true)
	{
		return $this->auth->attempt($credentials, $remember);
	}

	public function logout()
	{
		return $this->auth->logout();
	}

	public function user()
	{
		return $this->auth->user();
	}
	
	public function validate(array $credentials)
	{
		return $this->auth->validate($credentials);
	}

	public function ability($roles, $permissions, $options = [])
	{
		if ($user = $this->user())
		{
			return $user->ability($roles, $permissions, $options);
        }

        return false;
	}

	public function can($permission)
	{
		if ($user = $this->user())
		{
			return $user->can($permission);
        }

        return false;
	}

	public function hasRole($roleName)
	{
		if ($user = $this->user())
		{
			return $user->hasRole($roleName);
        }

        return false;
	}

}