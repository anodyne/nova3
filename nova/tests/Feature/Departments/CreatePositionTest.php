<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionCreated;
use Nova\Departments\Models\Position;
use Nova\Departments\Requests\CreatePositionRequest;
test('authorized user can view the create position', function () {
    $this->signInWithPermission('department.create');

    $response = $this->get(route('positions.create'));
    $response->assertSuccessful();
});
test('authorized user can create position', function () {
    $this->signInWithPermission('department.create');

    $position = Position::factory()->make();

    $this->followingRedirects();

    $response = $this->post(
        route('positions.store'),
        $position->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas(
        'positions',
        $position->only('name', 'description')
    );

    $this->assertRouteUsesFormRequest(
        'positions.store',
        CreatePositionRequest::class
    );
});
test('event is dispatched when position is created', function () {
    Event::fake();

    $this->signInWithPermission('department.create');

    $this->post(
        route('positions.store'),
        Position::factory()->make()->toArray()
    );

    Event::assertDispatched(PositionCreated::class);
});
test('unauthorized user cannot view the create position page', function () {
    $this->signIn();

    $response = $this->get(route('positions.create'));
    $response->assertForbidden();
});
test('unauthorized user cannot create position', function () {
    $this->signIn();

    $response = $this->postJson(
        route('positions.store'),
        Position::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the create position page', function () {
    $response = $this->getJson(route('positions.create'));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot create position', function () {
    $response = $this->postJson(
        route('positions.store'),
        Position::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
