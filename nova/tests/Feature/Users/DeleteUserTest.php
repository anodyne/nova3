<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Characters\Models\Character;
use Nova\Users\Events\UserDeleted;
use Nova\Users\Events\UserDeletedByAdmin;
use Nova\Users\Models\User;
beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
test('authorized user can delete user', function () {
    $this->signInWithPermission('user.delete');

    $this->followingRedirects();

    $response = $this->delete(route('users.destroy', $this->user));
    $response->assertSuccessful();

    $this->assertSoftDeleted('users', $this->user->only('id'));
});
test('events are dispatched when user is deleted', function () {
    Event::fake();

    $this->signInWithPermission('user.delete');

    $this->delete(route('users.destroy', $this->user));

    Event::assertDispatched(UserDeleted::class);
    Event::assertDispatched(UserDeletedByAdmin::class);
});
test('characters assigned to the user are deleted when the user is deleted', function () {
    $character = Character::factory()->active()->create();
    $this->user->characters()->attach($character);

    $this->signInWithPermission('user.delete');

    $response = $this->delete(route('users.destroy', $this->user));

    $this->assertSoftDeleted('users', $this->user->only('id'));

    $this->assertSoftDeleted('characters', $character->only('id'));
});
test('current user cannot delete their account from user management', function () {
    $this->signInWithPermission('user.delete');

    $response = $this->delete(
        route('users.destroy', $user = auth()->user())
    );
    $response->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'deleted_at' => null,
    ]);
});
test('unauthorized user cannot delete user', function () {
    $this->signIn();

    $response = $this->delete(route('users.destroy', $this->user));
    $response->assertForbidden();
});
test('unauthenticated user cannot delete user', function () {
    $response = $this->deleteJson(route('users.destroy', $this->user));
    $response->assertUnauthorized();
});
