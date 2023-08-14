<?php

declare(strict_types=1);
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Models\Role;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->role = Role::factory()->create();
    $this->role->givePermissions([1, 2]);
});
it('duplicates a role', function () {
    $role = DuplicateRole::run($this->role);

    expect($role->display_name)->toEqual("Copy of {$this->role->display_name}");

    expect($role->permissions->count())->toEqual($this->role->permissions->count());
});
