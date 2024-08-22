<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\from;
use function Pest\Laravel\get;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: 'character.create-secondary');
});

test('user can view the create characters page', function () {
    get(route('admin.characters.create'))
        ->assertSuccessful();
});

test('with approval required user can create character', function () {
    updateSettings(
        fn ($settings) => $settings->characters->approveSecondary = true
    );

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => null,
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertSuccessful();

    assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'secondary',
        'status' => 'pending',
    ]);
});

test('without approval user can create character', function () {
    updateSettings(
        fn ($settings) => $settings->characters->approveSecondary = false
    );

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => null,
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertSuccessful();

    assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'secondary',
        'status' => 'active',
    ]);
});

test('user cannot directly create primary character', function () {
    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => (string) auth()->id(),
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});

test('user cannot directly create support character', function () {
    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => false,
        'assign_as_primary' => false,
        'assigned_users' => null,
        'primary_users' => null,
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});

test('user cannot create secondary character for another user', function () {
    $user = User::factory()->active()->create();

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => false,
        'assign_as_primary' => false,
        'assigned_users' => (string) $user->id,
        'primary_users' => null,
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
