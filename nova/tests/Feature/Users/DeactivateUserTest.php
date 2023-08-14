<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Inactive as InactiveCharacter;
use Nova\Users\Models\States\Inactive as InactiveUser;
use Nova\Users\Models\User;
beforeEach(function () {
    $this->user = User::factory()->active()->create();

    $this->character = Character::factory()->active()->create();
    $this->character->users()->attach($this->user);
});
test('authorized user can deactivate user', function () {
    $this->signInWithPermission('user.update');

    $this->followingRedirects();

    $response = $this->post(route('users.deactivate', $this->user));
    $response->assertSuccessful();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'status' => InactiveUser::$name,
    ]);

    $this->assertDatabaseHas('characters', [
        'id' => $this->character->id,
        'status' => InactiveCharacter::$name,
    ]);
});
test('unauthorized user cannot deactivate user', function () {
    $this->signIn();

    $this->followingRedirects();

    $response = $this->post(route('users.deactivate', $this->user));
    $response->assertForbidden();
});
test('unauthenticated user cannot deactivate user', function () {
    $response = $this->postJson(route('users.deactivate', $this->user));
    $response->assertUnauthorized();
});
