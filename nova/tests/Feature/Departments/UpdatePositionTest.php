<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionUpdated;
use Nova\Departments\Models\Position;
use Nova\Departments\Requests\UpdatePositionRequest;
beforeEach(function () {
    $this->position = Position::factory()->create();
});
test('authorized user can view the edit position page', function () {
    $this->signInWithPermission('department.update');

    $response = $this->get(route('positions.edit', $this->position));
    $response->assertSuccessful();
});
test('authorized user can update position', function () {
    $this->signInWithPermission('department.update');

    $position = Position::factory()->make();

    $this->followingRedirects();

    $response = $this->put(
        route('positions.update', $this->position),
        $position->toArray()
    );
    $response->assertSuccessful();

    $this->assertDatabaseHas('positions', $position->only('name'));

    $this->assertRouteUsesFormRequest(
        'positions.update',
        UpdatePositionRequest::class
    );
});
test('event is dispatched when position is updated', function () {
    Event::fake();

    $this->signInWithPermission('department.update');

    $this->put(
        route('positions.update', $this->position),
        Position::factory()->make()->toArray()
    );

    Event::assertDispatched(PositionUpdated::class);
});
test('unauthorized user cannot view the edit position page', function () {
    $this->signIn();

    $response = $this->get(route('positions.edit', $this->position));
    $response->assertForbidden();
});
test('unauthorized user cannot update position', function () {
    $this->signIn();

    $response = $this->putJson(
        route('positions.update', $this->position),
        Position::factory()->make()->toArray()
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot view the edit position page', function () {
    $response = $this->getJson(route('positions.edit', $this->position));
    $response->assertUnauthorized();
});
test('unauthenticated user cannot update position', function () {
    $response = $this->putJson(
        route('positions.update', $this->position),
        Position::factory()->make()->toArray()
    );
    $response->assertUnauthorized();
});
