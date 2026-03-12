<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\DepartmentUpdated;
use Nova\Departments\Models\Department;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\castAsJson;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('departments');

beforeEach(function () {
    $this->department = Department::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('can view the edit department page', function () {
        get(route('admin.departments.edit', $this->department))->assertSuccessful();
    });

    test('can update a department', function () {
        Event::fake();

        $data = Department::factory()->active()->forRequest();

        from(route('admin.departments.edit', $this->department))
            ->followingRedirects()
            ->put(route('admin.departments.update', $this->department), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Department::class, $data->model->toArray());

        Event::assertDispatched(DepartmentUpdated::class);
    });

    test('can update a department to active', function () {
        Event::fake();

        $department = Department::factory()->inactive()->create();

        $data = Department::factory()->active()->forRequest();

        from(route('admin.departments.edit', $department))
            ->followingRedirects()
            ->put(route('admin.departments.update', $department), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Department::class, [
            'id' => $department->id,
            'status' => 'active',
        ]);
    });

    test('can update a department to inactive', function () {
        Event::fake();

        $department = Department::factory()->active()->create();

        $data = Department::factory()->inactive()->forRequest();

        from(route('admin.departments.edit', $department))
            ->followingRedirects()
            ->put(route('admin.departments.update', $department), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Department::class, [
            'id' => $department->id,
            'status' => 'inactive',
        ]);
    });

    test('can add a department header image', function () {})->todo();

    test('can remove an uploaded department header image', function () {})->todo();

    test('can replace an uploaded department header image', function () {})->todo();

    test('inputs are validated', function () {
        from(route('admin.departments.edit', $this->department))
            ->put(route('admin.departments.update', $this->department), [])
            ->assertSessionHasErrors(['name']);
    });

    test('can update a department with optional fields', function () {
        Event::fake();

        $position = Department::factory()->active()->create([
            'description' => 'Original description',
            'tags' => ['old-tag'],
        ]);

        from(route('admin.departments.edit', $position))
            ->followingRedirects()
            ->put(route('admin.departments.update', $position), [
                'name' => 'Updated Name',
                'description' => '',
                'tags' => '',
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Department::class, [
            'id' => $position->id,
            'name' => 'Updated Name',
            'description' => null,
            'tags' => castAsJson(['']),
        ]);
    });

    test('can update a department with tags', function () {
        Event::fake();

        $department = Department::factory()->active()->create();

        from(route('admin.departments.edit', $department))
            ->followingRedirects()
            ->put(route('admin.departments.update', $department), [
                'name' => $department->name,
                'tags' => 'tag1, tag2, tag3',
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Department::class, [
            'id' => $department->id,
            'tags' => castAsJson(['tag1', 'tag2', 'tag3']),
        ]);
    });

    test('tags are trimmed when updating a department', function () {
        Event::fake();

        $department = Department::factory()->active()->create();

        from(route('admin.departments.edit', $department))
            ->followingRedirects()
            ->put(route('admin.departments.update', $department), [
                'name' => $department->name,
                'tags' => '  tag1  ,  tag2  ,  tag3  ',
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Department::class, [
            'id' => $department->id,
            'tags' => castAsJson(['tag1', 'tag2', 'tag3']),
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit department page', function () {
        get(route('admin.departments.edit', $this->department))
            ->assertForbidden();
    });

    test('cannot update a department', function () {
        put(route('admin.departments.update', $this->department), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit department page', function () {
        get(route('admin.departments.edit', $this->department))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a department', function () {
        put(route('admin.departments.update', $this->department), [])
            ->assertRedirectToRoute('login');
    });
});
