<?php

declare(strict_types=1);

use function Pest\Laravel\get;

uses()->group('dashboards');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'system.error-logs'));

    test('can view the system error logs dashboard', function () {
        get(route('admin.error-logs.index'))
            ->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the system error logs dashboard', function () {
        get(route('admin.error-logs.index'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the system error logs dashboard', function () {
        get(route('admin.error-logs.index'))
            ->assertRedirectToRoute('login');
    });
});
