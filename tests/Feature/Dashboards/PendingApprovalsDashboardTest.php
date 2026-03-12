<?php

declare(strict_types=1);

use function Pest\Laravel\get;

uses()->group('dashboards');

describe('authorized user', function () {
    test('can view the pending approval dashboard with announcement approval permissions', function () {
        signIn(permissions: 'announcement.approve');

        get(route('admin.pending-approval'))
            ->assertSuccessful();
    });

    test('can view the pending approval dashboard with post approval permissions', function () {
        signIn(permissions: 'post.approve');

        get(route('admin.pending-approval'))
            ->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the pending approvals dashboard', function () {
        get(route('admin.pending-approval'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the pending approvals dashboard', function () {
        get(route('admin.pending-approval'))
            ->assertRedirectToRoute('login');
    });
});
