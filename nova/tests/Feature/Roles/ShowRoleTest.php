<?php

declare(strict_types=1);
use Nova\Roles\Models\Role;
beforeEach(function () {
    $this->role = Role::factory()->create();
});
test('authorized user can view a role', function () {
    $this->signInWithPermission('role.view');

    $response = $this->get(route('roles.show', $this->role));
    $response->assertSuccessful();
    $response->assertViewHas('role', $this->role);
});
test('unauthorized user cannot view a role', function () {
    $this->signIn();

    $response = $this->get(route('roles.show', $this->role));
    $response->assertForbidden();
});
test('unauthenticated user cannot view a role', function () {
    $response = $this->getJson(route('roles.show', $this->role));
    $response->assertUnauthorized();
});
