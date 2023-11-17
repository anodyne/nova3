<?php

declare(strict_types=1);

use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

uses()->group('characters');
uses(\Tests\UsesSettings::class);

test('user can view the create characters page', function () {
    $this->signInWithPermission('character.create-primary');

    $response = $this->get(route('characters.create'));
    $response->assertSuccessful();
});
test('with primary approval required user can create character', function () {
    $this->updateSetting(
        fn ($settings) => $settings->characters->approvePrimary = true
    );

    $this->signInWithPermission('character.create-primary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => (string) auth()->id(),
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertSuccessful();

    $this->assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'primary',
        'status' => 'pending',
    ]);
});
test('without approval required user can create character', function () {
    $this->updateSetting(
        fn ($settings) => $settings->characters->approvePrimary = false
    );

    $this->signInWithPermission('character.create-primary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => (string) auth()->id(),
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertSuccessful();

    $this->assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'primary',
        'status' => 'active',
    ]);
});
test('user cannot directly create secondary character', function () {
    $this->signInWithPermission('character.create-primary');

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => null,
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertForbidden();

    $this->assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'primary',
    ]);
});
test('user cannot directly create support character', function () {
    $this->signInWithPermission('character.create-primary');

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
        'type' => 'primary',
    ]);
});
test('with approval required user cannot create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(
        fn ($settings) => $settings->characters->approvePrimary = true
    );

    $this->signInWithPermission('character.create-primary');

    $user = auth()->user();

    $oldPrimaryCharacter = Character::factory()->primary()->active()->create([
        'name' => 'Jean Luc Picard',
    ]);

    $user->characters()->attach($oldPrimaryCharacter->id, ['primary' => true]);

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => (string) auth()->id(),
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_pending)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('without approval required user cannot create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(
        fn ($settings) => $settings->characters->approvePrimary = false
    );

    $this->signInWithPermission('character.create-primary');

    $user = auth()->user();

    $oldPrimaryCharacter = Character::factory()->primary()->active()->create([
        'name' => 'Jean Luc Picard',
    ]);

    $user->characters()->attach($oldPrimaryCharacter->id, ['primary' => true]);

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => true,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => (string) auth()->id(),
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_inactive)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);
});
test('user cannot create primary character for another user', function () {
    $this->signInWithPermission('character.create-primary');

    $user = User::factory()->active()->create();

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => false,
        'assign_as_primary' => true,
        'assigned_users' => (string) $user->id,
        'primary_users' => (string) $user->id,
    ];

    $this->followingRedirects();
    $response = $this->post(route('characters.store'), $postData);
    $response->assertForbidden();

    $this->assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
