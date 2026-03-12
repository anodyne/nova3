<?php

declare(strict_types=1);

use Nova\Addons\Models\Addon;

use function Pest\Laravel\get;

uses()->group('addons');

beforeEach(function () {
    $this->addon = Addon::factory()->genre()->active()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'addon.view');
    });

    test('can view an add-on', function () {
        get(route('admin.addons.show', $this->addon))
            ->assertSuccessful()
            ->assertSeeText($this->addon->name);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view an add-on', function () {
        get(route('admin.addons.show', $this->addon))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view an add-on', function () {
        get(route('admin.addons.show', $this->addon))
            ->assertRedirectToRoute('login');
    });
});
