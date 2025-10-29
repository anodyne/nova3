<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionCreated;
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
        get(route('admin.positions.create'))->assertSuccessful();
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
