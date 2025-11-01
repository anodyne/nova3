<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionUpdated;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\castAsJson;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->position = Position::factory()->active()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('can view the edit position page', function () {
        get(route('admin.positions.edit', $this->position))->assertSuccessful();
    });

    test('edit page loads departments list', function () {
        $departments = Department::factory()->count(3)->create();

        $response = get(route('admin.positions.edit', $this->position));

        $response->assertSuccessful();
        foreach ($departments as $department) {
            $response->assertSee($department->name);
        }
    });

    test('edit page pre-populates all fields correctly', function () {
        $position = Position::factory()->create([
            'name' => 'Test Position Name',
            'description' => 'Test Position Description',
            'available' => 5,
            'tags' => ['tag1', 'tag2'],
        ]);

        $response = get(route('admin.positions.edit', $position));

        $response->assertSuccessful();
        $response->assertSee('Test Position Name');
        $response->assertSee('Test Position Description');
        $response->assertSee('5');
    });

    test('can update a position', function () {
        Event::fake();

        $data = Position::factory()->active()->forRequest();

        from(route('admin.positions.edit', $this->position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $this->position), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Position::class, $data->model->toArray());

        Event::assertDispatched(PositionUpdated::class);
    });

    test('can update a position to active', function () {
        Event::fake();

        $position = Position::factory()->inactive()->create();

        $data = Position::factory()->active()->forRequest();

        from(route('admin.positions.edit', $position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $position), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'id' => $position->id,
            'status' => 'active',
        ]);
    });

    test('can update a position to inactive', function () {
        Event::fake();

        $position = Position::factory()->active()->create();

        $data = Position::factory()->inactive()->forRequest();

        from(route('admin.positions.edit', $position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $position), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'id' => $position->id,
            'status' => 'inactive',
        ]);
    });

    test('can move a position to a different department', function () {
        Event::fake();

        $position = Position::factory()->active()->create();

        $newDepartment = Department::factory()->active()->create();

        $data = Position::factory()->active()->forRequest([
            'department_id' => $newDepartment->id,
        ]);

        from(route('admin.positions.edit', $position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $position), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'id' => $position->id,
            'department_id' => $newDepartment->id,
        ]);
    });

    test('inputs are validated', function () {
        from(route('admin.positions.edit', $this->position))
            ->put(route('admin.positions.update', $this->position), [])
            ->assertSessionHasErrors(['name', 'department_id', 'available']);

        from(route('admin.positions.edit', $this->position))
            ->put(route('admin.positions.update', $this->position), [
                'name' => '',
                'department_id' => '',
                'available' => '',
            ])
            ->assertSessionHasErrors(['name', 'department_id', 'available']);

        from(route('admin.positions.edit', $this->position))
            ->put(route('admin.positions.update', $this->position), [
                'name' => 'Test Position',
                'department_id' => 999999,
                'available' => 1,
            ])
            ->assertSessionHasErrors(['department_id']);

        from(route('admin.positions.edit', $this->position))
            ->put(route('admin.positions.update', $this->position), [
                'name' => 'Test Position',
                'department_id' => 1,
                'available' => 'not-a-number',
            ])
            ->assertSessionHasErrors(['available']);

        from(route('admin.positions.edit', $this->position))
            ->put(route('admin.positions.update', $this->position), [
                'name' => 'Test Position',
                'department_id' => 1,
                'available' => -1,
            ])
            ->assertSessionHasErrors(['available']);
    });

    test('can update a position with optional fields', function () {
        Event::fake();

        $position = Position::factory()->active()->create([
            'description' => 'Original description',
            'tags' => ['old-tag'],
        ]);

        from(route('admin.positions.edit', $position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $position), [
                'name' => 'Updated Name',
                'department_id' => $position->department_id,
                'available' => $position->available,
                'description' => '',
                'tags' => '',
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'id' => $position->id,
            'name' => 'Updated Name',
            'description' => null,
            'tags' => castAsJson(['']),
        ]);
    });

    test('can update a position with tags', function () {
        Event::fake();

        $position = Position::factory()->active()->create();

        from(route('admin.positions.edit', $position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $position), [
                'name' => $position->name,
                'department_id' => $position->department_id,
                'available' => $position->available,
                'tags' => 'tag1, tag2, tag3',
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'id' => $position->id,
            'tags' => castAsJson(['tag1', 'tag2', 'tag3']),
        ]);
    });

    test('tags are trimmed when updating a position', function () {
        Event::fake();

        $position = Position::factory()->active()->create();

        from(route('admin.positions.edit', $position))
            ->followingRedirects()
            ->put(route('admin.positions.update', $position), [
                'name' => $position->name,
                'department_id' => $position->department_id,
                'available' => $position->available,
                'tags' => '  tag1  ,  tag2  ,  tag3  ',
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'id' => $position->id,
            'tags' => castAsJson(['tag1', 'tag2', 'tag3']),
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit position page', function () {
        get(route('admin.positions.edit', $this->position))
            ->assertForbidden();
    });

    test('cannot update a position', function () {
        put(route('admin.positions.update', $this->position), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit position page', function () {
        get(route('admin.positions.edit', $this->position))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a position', function () {
        put(route('admin.positions.update', $this->position), [])
            ->assertRedirectToRoute('login');
    });
});
