<?php

declare(strict_types=1);
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

uses()->group('characters');
uses(\Tests\UsesSettings::class);

test('without primary and secondary approvals required user can create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = false;
        $settings->characters->approveSecondary = false;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-secondary',
    ]);

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
    expect(CharacterType::secondary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('with primary approval and secondary without approval user can create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = true;
        $settings->characters->approveSecondary = false;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-secondary',
    ]);

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
test('with primary without approval and secondary with approval user can create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = false;
        $settings->characters->approveSecondary = true;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-secondary',
    ]);

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

    expect($oldPrimaryCharacter->is_pending)->toBeTrue();
    expect(CharacterType::secondary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('with primary and secondary approval user can create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = true;
        $settings->characters->approveSecondary = true;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-secondary',
    ]);

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
test('user cannot directly create support character', function () {
    $this->signInWithPermission([
        'character.create-primary',
        'character.create-secondary',
    ]);

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
