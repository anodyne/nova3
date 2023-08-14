<?php

declare(strict_types=1);
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;

uses()->group('characters');
uses(\Tests\UsesSettings::class);

test('without primary and support approvals required user cannot create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = false;
        $settings->characters->approveSupport = false;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-support',
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

    expect($oldPrimaryCharacter->status->equals(Inactive::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->status->equals(Active::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('with primary and support approvals required user cannot create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = true;
        $settings->characters->approveSupport = true;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-support',
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

    expect($oldPrimaryCharacter->status->equals(Active::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->status->equals(Pending::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('with primary approval and without support approval user cannot create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = true;
        $settings->characters->approveSupport = false;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-support',
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

    expect($oldPrimaryCharacter->status->equals(Active::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->status->equals(Pending::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('without primary approval and with support approval user cannot create additional secondary characters by creating new primary character', function () {
    $this->updateSetting(function ($settings) {
        $settings->characters->approvePrimary = false;
        $settings->characters->approveSupport = true;
    });

    $this->signInWithPermission([
        'character.create-primary',
        'character.create-support',
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

    expect($oldPrimaryCharacter->status->equals(Inactive::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->status->equals(Active::class))->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});
test('user cannot directly create secondary character', function () {
    $this->signInWithPermission([
        'character.create-primary',
        'character.create-support',
    ]);

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
    ]);
});
