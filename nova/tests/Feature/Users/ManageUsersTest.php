<?php

declare(strict_types=1);
use Nova\Characters\Models\Character;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

beforeEach(function () {
    $this->activeUser = User::factory()->active()->create();

    $this->pendingUser = User::factory()->create();

    $this->inactiveUser = User::factory()->inactive()->create();
});
test('authorized user with create permission can view manage users page', function () {
    $this->signInWithPermission('user.create');

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage users page', function () {
    $this->signInWithPermission('user.update');

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage users page', function () {
    $this->signInWithPermission('user.delete');

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage users page', function () {
    $this->signInWithPermission('user.view');

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();
});
test('manage users page can show all users', function () {
    $this->signInWithPermission('user.view');

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::count());
});
test('manage users page can show only active users', function () {
    $this->signInWithPermission('user.view');

    $response = $this->get(route('users.index', 'status=active'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::whereState('status', Active::class)->count());
});
test('manage users page can show only pending users', function () {
    $this->signInWithPermission('user.view');

    $response = $this->get(route('users.index', 'status=pending'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::whereState('status', Pending::class)->count());
});
test('manage users page can show only inactive users', function () {
    $this->signInWithPermission('user.view');

    $response = $this->get(route('users.index', 'status=inactive'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::whereState('status', Inactive::class)->count());
});
test('users can be filtered by name', function () {
    $this->signInWithPermission('user.create');

    User::factory()->active()->create([
        'name' => 'Sparrow Capitan',
    ]);

    User::factory()->active()->create();

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::count());

    $response = $this->get(route('users.index', 'search=sparrow'));
    $response->assertSuccessful();

    expect($response['users'])->toHaveCount(1);
});
test('users can be filtered by email', function () {
    $this->signInWithPermission('user.create');

    User::factory()->active()->create([
        'email' => 'sparrow@example.com',
    ]);

    User::factory()->active()->create();

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::count());

    $response = $this->get(route('users.index', 'search=sparrow@example.com'));
    $response->assertSuccessful();

    expect($response['users'])->toHaveCount(1);
});
test('users can be filtered by any of their assigned character names', function () {
    $this->signInWithPermission('user.create');

    $depp = User::factory()->active()->create([
        'name' => 'Johnny Depp',
    ]);

    User::factory()->active()->create();

    $character = Character::factory()->active()->create([
        'name' => 'Jack Sparrow',
    ]);
    $character->users()->attach($depp);

    $response = $this->get(route('users.index'));
    $response->assertSuccessful();

    expect($response['users']->total())->toEqual(User::count());

    $response = $this->get(route('users.index', 'search=sparrow'));
    $response->assertSuccessful();

    expect($response['users'])->toHaveCount(1);
});
test('unauthorized user cannot view manage users page', function () {
    $this->signIn();

    $response = $this->get(route('users.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage users page', function () {
    $response = $this->getJson(route('users.index'));
    $response->assertUnauthorized();
});
