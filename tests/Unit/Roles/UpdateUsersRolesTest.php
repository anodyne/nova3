<?php

use Nova\Roles\Models\Role;
use Nova\Users\Models\User;
use Nova\Roles\Actions\UpdateUsersRoles;
use Nova\Roles\DataTransferObjects\RoleAssignmentData;

uses()->group('unit', 'roles');

beforeEach(function () {
    $this->user = $this->createUser();

    $this->role = Role::create(['name' => 'test-role']);

    $this->action = new UpdateUsersRoles;
});

it('can give a user a role', function () {
    $this->assertFalse($this->user->isA('test-role'));

    $this->action->execute(new RoleAssignmentData([
        'role' => $this->role,
        'users' => User::whereIn('id', [$this->user->id])->get(),
    ]));

    $this->assertTrue($this->user->isA('test-role'));
});

it('can revoke a role from a user', function () {
    $this->user->attachRole('test-role');

    $this->assertTrue($this->user->isA('test-role'));

    $this->action->execute(new RoleAssignmentData([
        'role' => $this->role,
        'users' => collect(),
    ]));

    $this->assertFalse($this->user->isA('test-role'));
});
