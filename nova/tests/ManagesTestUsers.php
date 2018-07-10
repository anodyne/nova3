<?php

namespace Tests;

use Nova\Users\User;

trait ManagesTestUsers
{
    protected function createAdmin()
	{
		return factory(User::class)->states('admin')->create();
	}

	protected function createPowerUser()
	{
		return factory(User::class)->states('power-user')->create();
	}

	protected function createUser()
	{
		return factory(User::class)->states('active-user')->create();
	}

	protected function signIn($user = null)
	{
		$user = $user ?: $this->createUser();

		$this->actingAs($user);
	}

	protected function signOut()
	{
		auth()->logout();
	}
}
