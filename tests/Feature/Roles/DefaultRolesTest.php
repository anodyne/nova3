<?php

declare(strict_types=1);

use Nova\Applications\Actions\AcceptApplicationManager;
use Nova\Applications\Data\ApplicationDecisionData;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\from;

test('user created through the admin panel has the default roles', function () {
    signIn(permissions: 'user.create');

    $role1 = Role::factory()->default()->create();
    $role2 = Role::factory()->default()->create();
    $role3 = Role::factory()->notDefault()->create();

    from(route('admin.users.create'))
        ->followingRedirects()
        ->post(route('admin.users.store'), User::factory()->make()->toArray());

    $user = User::latest('id')->first();

    assertDatabaseHas('role_user', [
        'role_id' => $role1->id,
        'user_id' => $user->id,
    ]);

    assertDatabaseHas('role_user', [
        'role_id' => $role2->id,
        'user_id' => $user->id,
    ]);

    assertDatabaseMissing('role_user', [
        'role_id' => $role3->id,
        'user_id' => $user->id,
    ]);
})->group('roles', 'users');

test('user accepted through application review has the default roles', function () {
    signIn(permissions: 'application.approve');

    $role1 = Role::factory()->default()->create();
    $role2 = Role::factory()->default()->create();
    $role3 = Role::factory()->notDefault()->create();

    from(route('public.join'))
        ->followingRedirects()
        ->post(route('public.join.process'), [
            'userInfo' => [
                'name' => 'Patrick Stewart',
                'email' => 'patrick.stewart@example.test',
                'password' => 'password',
            ],
            'characterInfo' => [
                'name' => 'Jean-Luc Picard',
                'positions' => [],
            ],
        ]);

    $user = User::latest('id')->first();

    AcceptApplicationManager::run(
        $user->application,
        ApplicationDecisionData::from(
            message: 'Acceptance message',
            rank_id: null,
            positions: []
        )
    );

    assertDatabaseHas('role_user', [
        'role_id' => $role1->id,
        'user_id' => $user->id,
    ]);

    assertDatabaseHas('role_user', [
        'role_id' => $role2->id,
        'user_id' => $user->id,
    ]);

    assertDatabaseMissing('role_user', [
        'role_id' => $role3->id,
        'user_id' => $user->id,
    ]);
})->group('roles', 'users', 'join-form');
