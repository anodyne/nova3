<?php

declare(strict_types=1);

use Nova\Departments\Models\Department;

use function Pest\Laravel\get;

uses()->group('departments');

beforeEach(function () {
    $this->department = Department::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.view');
    });

    test('can view the view department page', function () {
        get(route('departments.show', $this->department))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view department page', function () {
        get(route('departments.show', $this->department))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view department page', function () {
        get(route('departments.show', $this->department))
            ->assertRedirectToRoute('login');
    });
});
