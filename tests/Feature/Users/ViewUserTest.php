<?php

declare(strict_types=1);

use Nova\Users\Models\User;

use function Pest\Laravel\get;

uses()->group('users');

beforeEach(function () {
    $this->user = User::factory()->active()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'user.view');
    });

    test('can view the view user page', function () {
        get(route('users.show', $this->user))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view user page', function () {
        get(route('users.show', $this->user))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view user page', function () {
        get(route('users.show', $this->user))
            ->assertRedirect(route('login'));
    });
});
