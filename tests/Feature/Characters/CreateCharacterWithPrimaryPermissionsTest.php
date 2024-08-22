<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\from;
use function Pest\Laravel\get;

uses()->group('characters');

beforeEach(function () {
    signIn(permissions: 'character.create-primary');
});

test('user can view the create characters page', function () {
    get(route('admin.characters.create'))
        ->assertSuccessful();
});

test('with primary approval required user can create character', function () {
    updateSettings(
        fn ($settings) => $settings->characters->approvePrimary = true
    );

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
        ->assertSuccessful();

    assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'primary',
        'status' => 'pending',
    ]);
});

test('without approval required user can create character', function () {
    updateSettings(
        fn ($settings) => $settings->characters->approvePrimary = false
    );

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
        ->assertSuccessful();

    assertDatabaseHas(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'primary',
        'status' => 'active',
    ]);
});

test('user cannot directly create secondary character', function () {
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
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
        'type' => 'primary',
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
        'type' => 'primary',
    ]);
});

test('with approval required user cannot create additional secondary characters by creating new primary character', function () {
    updateSettings(
        fn ($settings) => $settings->characters->approvePrimary = true
    );

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

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
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

test('without approval required user cannot create additional secondary characters by creating new primary character', function () {
    updateSettings(
        fn ($settings) => $settings->characters->approvePrimary = false
    );

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

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertSuccessful();

    $user->refresh();

    expect($user->primaryCharacter)->toHaveCount(1);

    $oldPrimaryCharacter->refresh();

    expect($oldPrimaryCharacter->is_inactive)->toBeTrue();
    expect(CharacterType::primary)->toEqual($oldPrimaryCharacter->type);
});

test('user cannot create primary character for another user', function () {
    $user = User::factory()->active()->create();

    $postData = [
        'name' => 'Liam Shaw',
        'link_to_user' => false,
        'assign_as_primary' => true,
        'assigned_users' => (string) $user->id,
        'primary_users' => (string) $user->id,
    ];

    from(route('admin.characters.create'))
        ->followingRedirects()
        ->post(route('admin.characters.store'), $postData)
        ->assertForbidden();

    assertDatabaseMissing(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
