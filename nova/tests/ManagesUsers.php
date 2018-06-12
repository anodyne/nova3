<?php

namespace Tests;

use Nova\Authorize\Role;

trait ManagesUsers
{
    protected function createAdmin()
	{
		$user = $this->createUser();

		$user->attachRole(Role::name('System Admin')->first());

		return $user;
	}

	protected function createUser()
	{
		$user = create('Nova\Users\User');

		$user->attachRole(Role::name('Active User')->first());

		return $user;
	}

	protected function signIn($user = null)
	{
		$user = ($user) ?: $this->createUser();

		$this->actingAs($user);
	}

	protected function signOut()
	{
		auth()->logout();
	}
}
