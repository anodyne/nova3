<?php

declare(strict_types=1);

use Nova\Roles\Models\Role;

use function Pest\Laravel\get;

uses()->group('roles');

beforeEach(function () {
    $this->role = Role::factory()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'role.view'));

    test('can view the view role page', function () {
        get(route('admin.roles.show', $this->role))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the view role page', function () {
        get(route('admin.roles.show', $this->role))->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view role page', function () {
        get(route('admin.roles.show', $this->role))
            ->assertRedirectToRoute('login');
    });
});
