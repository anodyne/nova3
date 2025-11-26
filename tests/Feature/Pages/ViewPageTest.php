<?php

declare(strict_types=1);

use Nova\Pages\Models\Page;

use function Pest\Laravel\get;

uses()->group('pages');

beforeEach(fn () => $this->page = Page::factory()->basic()->create());

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'page.view'));

    test('can view the view page page', function () {
        get(route('admin.pages.show', $this->page))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the view page page', function () {
        get(route('admin.pages.show', $this->page))->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view page page', function () {
        get(route('admin.pages.show', $this->page))
            ->assertRedirectToRoute('login');
    });
});
