<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Pages\Events\PageUpdated;
use Nova\Pages\Models\Page;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('pages');

beforeEach(function () {
    $this->page = Page::factory()->active()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'page.update'));

    test('can view the edit page page', function () {
        get(route('admin.pages.edit', $this->page))->assertSuccessful();
    });

    test('can update a page', function () {
        Event::fake();

        $data = Page::factory()->active()->forRequest();

        from(route('admin.pages.edit', $this->page))
            ->followingRedirects()
            ->put(route('admin.pages.update', $this->page), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Page::class, [
            'id' => $this->page->id,
            'status' => 'active',
        ]);

        Event::assertDispatched(PageUpdated::class);
    });

    test('can update a page status from inactive to active', function () {
        Event::fake();

        $page = Page::factory()->inactive()->create();

        $data = Page::factory()->active()->forRequest();

        from(route('admin.pages.edit', $page))
            ->followingRedirects()
            ->put(route('admin.pages.update', $page), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'status' => 'active',
        ]);
    });

    test('can update a page status from active to inactive', function () {
        Event::fake();

        $page = Page::factory()->active()->create();

        $data = Page::factory()->inactive()->forRequest();

        from(route('admin.pages.edit', $page))
            ->followingRedirects()
            ->put(route('admin.pages.update', $page), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'status' => 'inactive',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the edit page page', function () {
        get(route('admin.pages.edit', $this->page))
            ->assertNotFound();
    });

    test('cannot update a page', function () {
        $data = Page::factory()->forRequest();

        put(route('admin.pages.update', $this->page), $data->payload)
            ->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit page page', function () {
        get(route('admin.pages.edit', $this->page))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a page', function () {
        put(route('admin.pages.update', $this->page), [])
            ->assertRedirectToRoute('login');
    });
});
