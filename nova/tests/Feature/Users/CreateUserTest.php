<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Nova\Users\Events\UserCreated;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Models\User;
use Nova\Users\Requests\CreateUserRequest;
beforeEach(function () {
    Mail::fake();

    User::truncate();
});
test('authorized user can view the create user page', function () {
    $this->signInWithPermission('user.create');

    $response = $this->get(route('users.create'));
    $response->assertSuccessful();
});
test('authorized user can create user', function () {
    $this->signInWithPermission('user.create');

    $data = User::factory()->make([
        'name' => 'Jack Sparrow',
    ]);

    $this->followingRedirects();

    $response = $this->post(route('users.store'), $data->toArray());
    $response->assertSuccessful();

    $this->assertDatabaseHas('users', $data->only('name', 'email'));

    $this->assertRouteUsesFormRequest(
        'users.store',
        CreateUserRequest::class
    );
});
test('events are dispatched when user is created', function () {
    Event::fake();

    $this->signInWithPermission('user.create');

    $this->post(
        route('users.store'),
        User::factory()->make()->toArray()
    );

    Event::assertDispatched(UserCreated::class);
    Event::assertDispatched(UserCreatedByAdmin::class);
});
test('unauthorized user cannot view create user page', function () {
    $this->signIn();

    $response = $this->get(route('users.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create user', function () {
    $this->signIn();

    $response = $this->post(
        route('users.store'),
        User::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view create user page', function () {
    $response = $this->getJson(route('users.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create user', function () {
    $response = $this->postJson(
        route('users.store'),
        User::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
