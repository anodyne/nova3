<?php

declare(strict_types=1);
use Nova\Departments\Models\Department;
beforeEach(function () {
    $this->department = Department::factory()->create();
});
test('authorized user can view a department', function () {
    $this->signInWithPermission('department.view');

    $response = $this->get(route('departments.show', $this->department));
    $response->assertSuccessful();
    $response->assertViewHas('department', $this->department);
});
test('unauthorized user cannot view a department', function () {
    $this->signIn();

    $response = $this->get(route('departments.show', $this->department));
    $response->assertNotFound();
});
test('unauthenticated user cannot view a department', function () {
    $response = $this->getJson(route('departments.show', $this->department));
    $response->assertUnauthorized();
});
