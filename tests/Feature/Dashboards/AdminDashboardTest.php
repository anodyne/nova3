<?php

declare(strict_types=1);

use function Pest\Laravel\get;

uses()->group('dashboards');

describe('authenticated user', function () {
    beforeEach(fn () => signIn());

    test('can view the admin dashboard', function () {
        get(route('admin.dashboard'))
            ->assertSuccessful();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the admin dashboard', function () {
        get(route('admin.system-overview'))
            ->assertRedirectToRoute('login');
    });
});
