<?php

use Nova\Roles\Models\Role;

uses()->group('unit', 'roles');

beforeEach(function () {
    $this->role = factory(Role::class)->create();
});

it('can give a role to a user', function () {
    $this->role->giveToUser($user = $this->createUser());

    $this->assertTrue($user->hasRole($this->role->name));
});
