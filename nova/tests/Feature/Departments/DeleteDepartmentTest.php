<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentDeleted;
use Nova\Departments\Models\Department;
beforeEach(function () {
    $this->department = Department::factory()->create();
});
test('authorized user can delete a department', function () {
    $this->signInWithPermission('department.delete');

    $this->followingRedirects();

    $response = $this->delete(
        route('departments.destroy', $this->department)
    );
    $response->assertSuccessful();

    $this->assertDatabaseMissing(
        'departments',
        $this->department->only('id')
    );
});
test('event is dispatched when department is deleted', function () {
    Event::fake();

    $this->signInWithPermission('department.delete');

    $this->delete(route('departments.destroy', $this->department));

    Event::assertDispatched(DepartmentDeleted::class);
});
test('unauthorized user cannot delete a department', function () {
    $this->signIn();

    $response = $this->delete(
        route('departments.destroy', $this->department)
    );
    $response->assertNotFound();
});
test('unauthenticated user cannot delete a department', function () {
    $response = $this->deleteJson(
        route('departments.destroy', $this->department)
    );
    $response->assertUnauthorized();
});
