<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active as ActiveCharacter;
use Nova\Users\Models\States\Status\Active as ActiveUser;
use Nova\Users\Models\User;

beforeEach(function () {
    $this->user = User::factory()->inactive()->create();

    $this->character = Character::factory()->inactive()->create();
    $this->character->users()->attach($this->user, ['primary' => true]);
});
test('authorized user can activate user', function () {
    $this->signInWithPermission('user.update');

    $this->followingRedirects();

    $response = $this->post(route('users.activate', $this->user));
    $response->assertSuccessful();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'status' => ActiveUser::$name,
    ]);
});
test('user can be activated with previous primary character', function () {
    $this->signInWithPermission('user.update');

    $this->followingRedirects();

    $response = $this->post(route('users.activate', $this->user), [
        'activate_primary_character' => '1',
    ]);
    $response->assertSuccessful();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'status' => ActiveUser::$name,
    ]);

    $this->assertDatabaseHas('characters', [
        'id' => $this->character->id,
        'status' => ActiveCharacter::$name,
    ]);
});
test('unauthorized user cannot activate user', function () {
    $this->signIn();

    $this->followingRedirects();

    $response = $this->post(route('users.activate', $this->user));
    $response->assertForbidden();
});
test('unauthenticated user cannot activate user', function () {
    $response = $this->postJson(route('users.activate', $this->user));
    $response->assertUnauthorized();
});
