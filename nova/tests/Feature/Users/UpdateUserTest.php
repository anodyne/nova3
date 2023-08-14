<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Users\Events\UserUpdated;
use Nova\Users\Events\UserUpdatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Requests\UpdateUserRequest;
beforeEach(function () {
    $this->user = User::factory()->active()->create();
});
test('authorized user can view the edit user page', function () {
    $this->signInWithPermission('user.update');

    $response = $this->get(route('users.edit', $this->user));
    $response->assertSuccessful();
});
test('authorized user can update user', function () {
    $this->signInWithPermission('user.update');

    $data = User::factory()->make([
        'email' => $this->user->email,
    ]);

    $this->followingRedirects();

    $response = $this->put(
        route('users.update', $this->user),
        array_merge($data->toArray(), ['status' => $this->user->status])
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => $data->name,
        'email' => $data->email,
    ]);

    $this->assertRouteUsesFormRequest(
        'users.update',
        UpdateUserRequest::class
    );
});
test('events are dispatched when user is updated', function () {
    Event::fake();

    $this->signInWithPermission('user.update');

    $this->put(
        route('users.update', $this->user),
        [
            'name' => 'Jack Sparrow',
            'email' => $this->user->email,
            'pronouns' => ['value' => $this->user->pronouns->value],
        ]
    );

    Event::assertDispatched(UserUpdated::class);
    Event::assertDispatched(UserUpdatedByAdmin::class);
});
test('unauthorized user cannot view the edit user page', function () {
    $this->signIn();

    $response = $this->get(route('users.edit', $this->user));
    $response->assertForbidden();
});
test('unauthorized user cannot update user', function () {
    $this->signIn();

    $this->followingRedirects();

    $response = $this->put(
        route('users.update', $this->user),
        User::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit user page', function () {
    $response = $this->getJson(route('users.edit', $this->user));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update user', function () {
    $response = $this->putJson(
        route('users.update', $this->user),
        User::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
