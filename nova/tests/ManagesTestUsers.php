<?php

namespace Tests;

use Nova\Users\Models\User;

trait ManagesTestUsers
{
    /**
     * Create an admin user.
     *
     * @param  array  $attributes
     *
     * @return User
     */
    protected function createAdmin(array $attributes = []): User
    {
        $admin = $this->createUser($attributes);

        $admin->attachRole('admin');

        return $admin;
    }

    /**
     * Create a user and persist it to the database.
     *
     * @param  array  $attributes
     *
     * @return User
     */
    protected function createUser(array $attributes = []): User
    {
        return factory(User::class)->create($attributes);
    }

    /**
     * Make a user.
     *
     * @param  array  $attributes
     *
     * @return User
     */
    protected function makeUser(array $attributes = []): User
    {
        return factory(User::class)->make($attributes);
    }

    /**
     * Sign in to the app.
     *
     * @param  null|User  $user
     *
     * @return User
     */
    protected function signIn(User $user = null): User
    {
        $user = $user ?? $this->createUser();

        $this->actingAs($user);

        return $user;
    }

    /**
     * Sign in to the app as an admin.
     *
     * @param  null|User  $user
     *
     * @return User
     */
    protected function signInAsAdmin(User $user = null): User
    {
        $user = $user ?? $this->createAdmin();

        $this->actingAs($user);

        return $user;
    }

    /**
     * Sign in to the app with a specific permission.
     *
     * @param  string|array  $permissions
     * @param  null|User  $user
     *
     * @return User
     */
    protected function signInWithPermission($permissions, User $user = null): User
    {
        $user = $user ?? $this->createUser();

        $permissions = (is_string($permissions)) ? [$permissions] : $permissions;

        $user->attachPermissions($permissions);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Sign out of the app.
     *
     * @return void
     */
    protected function signOut(): void
    {
        auth()->logout();
    }
}
