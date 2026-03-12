<?php

declare(strict_types=1);

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('addons');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.create');
    });

    test('can view the create add-on page', function () {
        get(route('admin.addons.create'))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create add-on page', function () {
        get(route('admin.addons.create'))->assertForbidden();
    });

    test('cannot create an add-on', function () {
        post(route('admin.addons.store'), [])->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create add-on page', function () {
        get(route('admin.addons.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create an add-on', function () {
        post(route('admin.addons.store'), [])
            ->assertRedirectToRoute('login');
    });
});
