<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionDeleted;
use Nova\Departments\Models\Position;
beforeEach(function () {
    $this->position = Position::factory()->create();
});
test('authorized user can delete a position', function () {
    $this->signInWithPermission('department.delete');

    $this->followingRedirects();

    $response = $this->delete(
        route('positions.destroy', $this->position)
    );
    $response->assertSuccessful();

    $this->assertDatabaseMissing(
        'positions',
        $this->position->only('id')
    );
});
test('event is dispatched when position is deleted', function () {
    Event::fake();

    $this->signInWithPermission('department.delete');

    $this->delete(route('positions.destroy', $this->position));

    Event::assertDispatched(PositionDeleted::class);
});
test('unauthorized user cannot delete a position', function () {
    $this->signIn();

    $response = $this->delete(
        route('positions.destroy', $this->position)
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot delete a position', function () {
    $response = $this->deleteJson(
        route('positions.destroy', $this->position)
    );
    $response->assertUnauthorized();
});
