<?php

declare(strict_types=1);

use Nova\Ranks\Models\RankItem;

use function Pest\Laravel\get;

uses()->group('ranks');

beforeEach(function () {
    $this->rankItem = RankItem::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'rank.view');
    });

    test('can view the view rank item page', function () {
        get(route('ranks.items.show', $this->rankItem))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view rank item page', function () {
        get(route('ranks.items.show', $this->rankItem))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view rank item page', function () {
        get(route('ranks.items.show', $this->rankItem))
            ->assertRedirect(route('login'));
    });
});
