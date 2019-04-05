<?php

namespace Tests;

use Nova\Users\User;

trait ManagesTestUsers
{
    protected function createAdmin(array $attributes = [])
    {
        $admin = $this->createUser($attributes);

        $admin->assign('admin');

        return $admin;
    }

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

    protected function signInAsAdmin(User $user = null)
    {
        $user = $user ?? $this->createAdmin();

        $this->actingAs($user);

        return $user;
    }

    protected function signInWithAbility($ability, User $user = null)
    {
        $user = $user ?? $this->createUser();

        $user->allow($ability);

        $this->actingAs($user);

        return $user;
    }

    protected function signOut()
    {
        auth()->logout();
    }
}
