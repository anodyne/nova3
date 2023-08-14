<?php

declare(strict_types=1);
use Nova\Roles\Models\Role;
test('authorized user with create permission can view manage roles page', function () {
    $this->signInWithPermission('role.create');

    $response = $this->get(route('roles.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage roles page', function () {
    $this->signInWithPermission('role.update');

    $response = $this->get(route('roles.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage roles page', function () {
    $this->signInWithPermission('role.delete');

    $response = $this->get(route('roles.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage roles page', function () {
    $this->signInWithPermission('role.view');

    $response = $this->get(route('roles.index'));
    $response->assertSuccessful();
});
test('roles can be filtered by display name', function () {
    $this->signInWithPermission('role.create');

    Role::factory()->create([
        'display_name' => 'barbaz',
    ]);

    $response = $this->get(route('roles.index'));
    $response->assertSuccessful();

    expect($response['roles']->total())->toEqual(Role::count());

    $response = $this->get(route('roles.index', 'search=barbaz'));
    $response->assertSuccessful();

    expect($response['roles'])->toHaveCount(1);
});
test('roles can be filtered by name', function () {
    $this->signInWithPermission('role.create');

    Role::factory()->create([
        'name' => 'foobar',
    ]);

    $response = $this->get(route('roles.index'));
    $response->assertSuccessful();

    expect($response['roles']->total())->toEqual(Role::count());

    $response = $this->get(route('roles.index', 'search=foobar'));
    $response->assertSuccessful();

    expect($response['roles'])->toHaveCount(1);
});
test('unauthorized user cannot view manage roles page', function () {
    $this->signIn();

    $response = $this->get(route('roles.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage roles page', function () {
    $response = $this->getJson(route('roles.index'));
    $response->assertUnauthorized();
});
