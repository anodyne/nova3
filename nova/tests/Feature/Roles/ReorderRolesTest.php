<?php

declare(strict_types=1);
use Nova\Roles\Models\Role;
beforeEach(function () {
    $this->role1 = Role::factory()->create(['sort' => 0]);
    $this->role2 = Role::factory()->create(['sort' => 1]);
    $this->role3 = Role::factory()->create(['sort' => 2]);
});
test('authorized user can reorder roles', function () {
    $this->signInWithPermission('role.update');

    $this->followingRedirects();

    $response = $this->post(
        route('roles.reorder'),
        [
            'sort' => implode(',', [
                $this->role3->id,
                $this->role2->id,
                $this->role1->id,
            ]),
        ]
    );
    $response->assertSuccessful();

    $this->role1->fresh();
    $this->role2->fresh();
    $this->role3->fresh();

    $this->assertDatabaseHas('roles', [
        'id' => $this->role1->id,
        'sort' => 2,
    ]);
    $this->assertDatabaseHas('roles', [
        'id' => $this->role2->id,
        'sort' => 1,
    ]);
    $this->assertDatabaseHas('roles', [
        'id' => $this->role3->id,
        'sort' => 0,
    ]);
});
test('unauthorized user cannot reorder roles', function () {
    $this->signIn();

    $response = $this->post(
        route('roles.reorder'),
        [
            'sort' => implode(',', [
                $this->role3->id,
                $this->role2->id,
                $this->role1->id,
            ]),
        ]
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot reorder roles', function () {
    $response = $this->postJson(
        route('roles.reorder'),
        [
            'sort' => implode(',', [
                $this->role3->id,
                $this->role2->id,
                $this->role1->id,
            ]),
        ]
    );
    $response->assertUnauthorized();
});
