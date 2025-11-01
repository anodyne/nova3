<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionCreated;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('departments');
uses()->group('positions');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('can view the create position page', function () {
        get(route('admin.positions.create'))
            ->assertSuccessful();
    });

    test('create page loads departments list', function () {
        $departments = Department::factory()->count(3)->create();

        get(route('admin.positions.create'))
            ->assertViewHas('departments', $departments);
    });

    test('create page can pre-select department from query parameter', function () {
        $department = Department::factory()->create();

        get(route('admin.positions.create', ['department' => $department->id]))
            ->assertSuccessful()
            ->assertSeeText($department->name);
    });

    test('can create a position', function () {
        Event::fake();

        $data = Position::factory()->active()->forRequest();

        from(route('admin.positions.create'))
            ->followingRedirects()
            ->post(route('admin.positions.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'name' => $data->model->name,
            'department_id' => $data->model->department_id,
            'status' => 'active',
        ]);

        Event::assertDispatched(PositionCreated::class);
    });

    test('inputs are validated', function () {
        from(route('admin.positions.create'))
            ->post(route('admin.positions.store'), [])
            ->assertSessionHasErrors(['name', 'department_id', 'available']);

        from(route('admin.positions.create'))
            ->post(route('admin.positions.store'), [
                'name' => '',
                'department_id' => '',
                'available' => '',
            ])
            ->assertSessionHasErrors(['name', 'department_id', 'available']);

        from(route('admin.positions.create'))
            ->post(route('admin.positions.store'), [
                'name' => 'Test Position',
                'department_id' => 999999,
                'available' => 1,
            ])
            ->assertSessionHasErrors(['department_id']);

        from(route('admin.positions.create'))
            ->post(route('admin.positions.store'), [
                'name' => 'Test Position',
                'department_id' => 1,
                'available' => 'not-a-number',
            ])
            ->assertSessionHasErrors(['available']);

        from(route('admin.positions.create'))
            ->post(route('admin.positions.store'), [
                'name' => 'Test Position',
                'department_id' => 1,
                'available' => -1,
            ])
            ->assertSessionHasErrors(['available']);
    });

    test('can create a position with optional fields', function () {
        Event::fake();

        $data = Position::factory()->active()->make([
            'description' => null,
            'tags' => null,
        ]);

        from(route('admin.positions.create'))
            ->followingRedirects()
            ->post(route('admin.positions.store'), [
                'name' => $data->name,
                'department_id' => $data->department_id,
                'available' => $data->available,
                'status' => 'true',
            ])
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'name' => $data->name,
            'department_id' => $data->department_id,
            'description' => null,
        ]);
    });

    test('can create a position with tags', function () {
        Event::fake();

        $data = Position::factory()->active()->make();

        from(route('admin.positions.create'))
            ->followingRedirects()
            ->post(route('admin.positions.store'), [
                'name' => $data->name,
                'department_id' => $data->department_id,
                'available' => $data->available,
                'tags' => 'tag1, tag2, tag3',
                'status' => 'true',
            ])
            ->assertSuccessful();

        $position = Position::where('name', $data->name)->first();

        expect($position->tags)->toEqual(['tag1', 'tag2', 'tag3']);
    });

    test('tags are trimmed when creating a position', function () {
        Event::fake();

        $data = Position::factory()->active()->make();

        from(route('admin.positions.create'))
            ->followingRedirects()
            ->post(route('admin.positions.store'), [
                'name' => $data->name,
                'department_id' => $data->department_id,
                'available' => $data->available,
                'tags' => '  tag1  ,  tag2  ,  tag3  ',
                'status' => 'true',
            ])
            ->assertSuccessful();

        $position = Position::where('name', $data->name)->first();

        expect($position->tags)->toEqual(['tag1', 'tag2', 'tag3']);
    });

    test('can create an inactive position', function () {
        Event::fake();

        $data = Position::factory()->inactive()->forRequest();

        from(route('admin.positions.create'))
            ->followingRedirects()
            ->post(route('admin.positions.store'), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Position::class, [
            'name' => $data->model->name,
            'department_id' => $data->model->department_id,
            'status' => 'inactive',
        ]);

        Event::assertDispatched(PositionCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create position page', function () {
        get(route('admin.positions.create'))->assertForbidden();
    });

    test('cannot create a position', function () {
        $data = Position::factory()->make();

        post(route('admin.positions.store'), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create position page', function () {
        get(route('admin.positions.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a position', function () {
        post(route('admin.positions.store'), [])
            ->assertRedirectToRoute('login');
    });
});
