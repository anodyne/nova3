<?php

declare(strict_types=1);

use Nova\Ranks\Models\RankGroup;

use function Pest\Laravel\get;

uses()->group('ranks');

beforeEach(function () {
    $this->rankGroup = RankGroup::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.view');
    });

    test('can view the view rank group page', function () {
        get(route('admin.ranks.groups.show', $this->rankGroup))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view rank group page', function () {
        get(route('admin.ranks.groups.show', $this->rankGroup))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view rank group page', function () {
        get(route('admin.ranks.groups.show', $this->rankGroup))
            ->assertRedirectToRoute('login');
    });
});
