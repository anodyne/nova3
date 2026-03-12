<?php

declare(strict_types=1);

use function Pest\Laravel\get;

uses()->group('dashboards');

describe('authenticated user', function () {
    beforeEach(fn () => signIn());

    test('can view the writing dashboard', function () {
        get(route('admin.writing-overview'))
            ->assertSuccessful();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the writing dashboard', function () {
        get(route('admin.writing-overview'))
            ->assertRedirectToRoute('login');
    });
});
