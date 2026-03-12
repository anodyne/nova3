<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Characters\Models\Character;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\from;
use function Pest\Laravel\get;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: 'character.create-support');
});

test('user can view the create characters page', function () {
    get(route('admin.characters.create'))
        ->assertSuccessful();
});

test('with approval required user can create character', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            approveSupport: true
        );

        return $settings;
    });

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
        ->assertSuccessful();

    assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'support',
        'status' => 'pending',
    ]);
});

test('without approval required user can create character', function () {
    updateSettings(function ($settings) {
        $settings->characters = $settings->characters->with(
            approveSupport: false
        );

        return $settings;
    });

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
        ->assertSuccessful();

    assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'support',
        'status' => 'active',
    ]);
});

test('user cannot directly create primary character', function () {
    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) Auth::id(),
        'primary_users' => (string) Auth::id(),
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});

test('user cannot directly create secondary character', function () {
    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) Auth::id(),
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
