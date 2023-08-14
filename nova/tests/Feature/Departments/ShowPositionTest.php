<?php

declare(strict_types=1);
use Nova\Departments\Models\Position;
beforeEach(function () {
    $this->position = Position::factory()->create();
});
test('authorized user can view a position', function () {
    $this->signInWithPermission('department.view');

    $response = $this->get(route('positions.show', $this->position));
    $response->assertSuccessful();
    $response->assertViewHas('position', $this->position);
});
test('unauthorized user cannot view a position', function () {
    $this->signIn();

    $response = $this->get(route('positions.show', $this->position));
    $response->assertForbidden();
});
test('unauthenticated user cannot view a position', function () {
    $response = $this->getJson(route('positions.show', $this->position));
    $response->assertUnauthorized();
});
