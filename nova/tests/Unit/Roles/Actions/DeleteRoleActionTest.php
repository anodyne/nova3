<?php

declare(strict_types=1);
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Models\Role;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->role = Role::factory()->create();
});
it('deletes a role', function () {
    $role = DeleteRole::run($this->role);

    expect($role->exists)->toBeFalse();
});
