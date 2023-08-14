<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

uses()->group('characters');
uses(\Tests\UsesSettings::class);

test('user can view the create characters page', function () {
    $this->signInWithPermission('character.create-secondary');

    $response = $this->get(route('characters.create'));
    $response->assertSuccessful();
});
test('with approval required user can create character', function () {
    $this->updateSetting(
        fn ($settings) => $settings->characters->approveSecondary = true
    );

    $this->signInWithPermission('character.create-secondary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => null,
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertSuccessful();

    $this->assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'secondary',
        'status' => 'pending',
    ]);
});
test('without approval user can create character', function () {
    $this->updateSetting(
        fn ($settings) => $settings->characters->approveSecondary = false
    );

    $this->signInWithPermission('character.create-secondary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => null,
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertSuccessful();

    $this->assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'secondary',
        'status' => 'active',
    ]);
});
test('user cannot directly create primary character', function () {
    $this->signInWithPermission('character.create-secondary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => (string) auth()->id(),
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertForbidden();

    $this->assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
test('user cannot directly create support character', function () {
    $this->signInWithPermission('character.create-secondary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => false,
        'assign_as_primary' => false,
        'assigned_users' => null,
        'primary_users' => null,
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertForbidden();

    $this->assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
test('user cannot create secondary character for another user', function () {
    $this->signInWithPermission('character.create-secondary');

    $user = User::factory()->active()->create();

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => false,
        'assign_as_primary' => false,
        'assigned_users' => (string) $user->id,
        'primary_users' => null,
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertForbidden();

    $this->assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
