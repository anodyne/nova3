<?php

declare(strict_types=1);

use Nova\Ranks\Models\RankName;

use function Pest\Laravel\get;

uses()->group('ranks');

beforeEach(function () {
    $this->rankName = RankName::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.view');
    });

    test('can view the view rank name page', function () {
        get(route('ranks.names.show', $this->rankName))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view rank name page', function () {
        get(route('ranks.names.show', $this->rankName))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view rank name page', function () {
        get(route('ranks.names.show', $this->rankName))
            ->assertRedirectToRoute('login');
    });
});
