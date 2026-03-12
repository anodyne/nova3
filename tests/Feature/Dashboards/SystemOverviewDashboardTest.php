<?php

declare(strict_types=1);

use function Pest\Laravel\get;

uses()->group('dashboards');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'system.overview'));

    test('can view the system overview dashboard', function () {
        get(route('admin.system-overview'))
            ->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the system overview dashboard', function () {
        get(route('admin.system-overview'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the system overview dashboard', function () {
        get(route('admin.system-overview'))
            ->assertRedirectToRoute('login');
    });
});
