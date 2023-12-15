<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;

use function Pest\Laravel\get;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'character.view');
    });

    test('can view the view character page', function () {
        get(route('characters.show', $this->character))
            ->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view character page', function () {
        get(route('characters.show', $this->character))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view character page', function () {
        get(route('characters.show', $this->character))
            ->assertRedirect(route('login'));
    });
});
