<?php

namespace Tests;

use Illuminate\Support\Arr;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

trait ManagesTestUsers
{
    protected function createAdmin(array $attributes = []): User
    {
        $admin = $this->createUser($attributes);

        $admin->attachRole(Role::create(['name' => 'admin']));

        return $admin;
    }

    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function makeUser(array $attributes = []): User
    {
        return User::factory()->make($attributes);
    }

    protected function signIn(User $user = null): self
    {
        $user = $user ?? $this->createUser();

        $this->actingAs($user);

        return $this;
    }

    protected function signInAsAdmin(User $user = null): self
    {
        $user = $user ?? $this->createAdmin();

        $this->actingAs($user);

        return $this;
    }

    protected function signInWithPermission($permissions, User $user = null): self
    {
        $user = $user ?? $this->createUser();

        $permissions = collect(Arr::wrap($permissions))
            ->each(fn ($permission) => Permission::factory()->create(['name' => $permission]))
            ->toArray();

        $user->attachPermissions($permissions);

        $this->actingAs($user);

        return $this;
    }

    protected function signOut(): void
    {
        auth()->logout();
    }
}
