<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\from;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: [
        'character.create-primary',
        'character.create-support',
    ]);
});

test('without primary and support approvals required user cannot create additional secondary characters by creating new primary character', function () {
    updateSettings(function ($settings) {
        $settings->characters->approvePrimary = false;
        $settings->characters->approveSupport = false;
    });

    /** @var User $user */
    $user = Auth::user();

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

    from(route('characters.create'))
        ->followingRedirects()
        ->post(route('characters.store'), $postData)
        ->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_inactive)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});

test('with primary and support approvals required user cannot create additional secondary characters by creating new primary character', function () {
    updateSettings(function ($settings) {
        $settings->characters->approvePrimary = true;
        $settings->characters->approveSupport = true;
    });

    /** @var User $user */
    $user = Auth::user();

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

    from(route('characters.create'))
        ->followingRedirects()
        ->post(route('characters.store'), $postData)
        ->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_pending)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});

test('with primary approval and without support approval user cannot create additional secondary characters by creating new primary character', function () {
    updateSettings(function ($settings) {
        $settings->characters->approvePrimary = true;
        $settings->characters->approveSupport = false;
    });

    /** @var User $user */
    $user = Auth::user();

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

    from(route('characters.create'))
        ->followingRedirects()
        ->post(route('characters.store'), $postData)
        ->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_pending)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});

test('without primary approval and with support approval user cannot create additional secondary characters by creating new primary character', function () {
    updateSettings(function ($settings) {
        $settings->characters->approvePrimary = false;
        $settings->characters->approveSupport = true;
    });

    /** @var User $user */
    $user = Auth::user();

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

    from(route('characters.create'))
        ->followingRedirects()
        ->post(route('characters.store'), $postData)
        ->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_inactive)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);

    $newPrimaryCharacter = Character::latest('id')->first();

    expect($newPrimaryCharacter->is_active)->toBeTrue();
    expect(CharacterType::primary)->toEqual($newPrimaryCharacter->type);
});

test('user cannot directly create secondary character', function () {
    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => true,
        'assign_as_primary' => false,
        'assigned_users' => (string) auth()->id(),
        'primary_users' => null,
    ];

    from(route('characters.create'))
        ->followingRedirects()
        ->post(route('characters.store'), $postData)
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
