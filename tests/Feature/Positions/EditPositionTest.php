<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Departments\Events\PositionUpdated;
use Nova\Departments\Models\Position;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->position = Position::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('can view the edit position page', function () {
        get(route('positions.edit', $this->position))->assertSuccessful();
    });

    test('can update a position', function () {
        Event::fake();

        $data = Position::factory()->make();

        from(route('positions.edit', $this->position))
            ->followingRedirects()
            ->put(route('positions.update', $this->position), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Position::class, $data->toArray());

        Event::assertDispatched(PositionUpdated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit position page', function () {
        get(route('positions.edit', $this->position))
            ->assertForbidden();
    });

    test('cannot update a position', function () {
        $data = Position::factory()->make();

        put(route('positions.update', $this->position), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit position page', function () {
        get(route('positions.edit', $this->position))
            ->assertRedirect(route('login'));
    });

    test('cannot update a position', function () {
        put(route('positions.update', $this->position), [])
            ->assertRedirect(route('login'));
    });
});
