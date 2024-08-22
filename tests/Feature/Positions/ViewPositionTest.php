<?php

declare(strict_types=1);

use Nova\Departments\Models\Position;

use function Pest\Laravel\get;

uses()->group('departments');
uses()->group('positions');

beforeEach(function () {
    $this->position = Position::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('can view the view position page', function () {
        get(route('admin.positions.show', $this->position))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view position page', function () {
        get(route('admin.positions.show', $this->position))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view position page', function () {
        get(route('admin.positions.show', $this->position))
            ->assertRedirectToRoute('login');
    });
});
