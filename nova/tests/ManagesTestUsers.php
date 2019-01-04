<?php

namespace Tests;

use Nova\Users\User;

trait ManagesTestUsers
{
    protected function createUser(array $attributes = [])
    {
        return factory(User::class)->create($attributes);
    }

    protected function makeUser(array $attributes = [])
    {
        return factory(User::class)->make($attributes);
    }

    protected function signIn(User $user = null)
    {
        $user = $user ?? $this->createUser();

        $this->actingAs($user);

        return $user;
    }

    protected function signOut()
	{
		auth()->logout();
	}
}