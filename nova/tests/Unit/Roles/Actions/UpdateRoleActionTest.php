<?php

declare(strict_types=1);
use Nova\Roles\Actions\UpdateRole;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Models\Role;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->disableRoleCaching();

    $this->role = Role::factory()->create();
});
it('can update a role', function () {
    $data = RoleData::from([
        'name' => 'foo',
        'display_name' => 'Foo',
        'description' => 'New description of foo',
        'default' => true,
    ]);

    $role = UpdateRole::run($this->role, $data);

    expect($role->name)->toEqual('foo');
    expect($role->display_name)->toEqual('Foo');
    expect($role->description)->toEqual('New description of foo');
    expect($role->default)->toBeTrue();
});
