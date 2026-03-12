<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Pages\Events\PageCreated;
use Nova\Pages\Models\Page;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('pages');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'page.create'));

    test('can view the create page page', function () {
        get(route('admin.pages.create'))->assertSuccessful();
    });

    test('can create a basic page', function () {
        Event::fake();

        $data = Page::factory()->active()->basic()->forRequest();

        from(route('admin.pages.create'))
            ->followingRedirects()
            ->post(route('admin.pages.store'), $data->payload)
            ->assertSuccessful();

        $form = Page::latest('id')->first();

        assertDatabaseHas(Page::class, [
            'id' => $form->id,
            'resource' => null,
        ]);

        Event::assertDispatched(PageCreated::class);
    });

    test('can create an advanced page', function () {
        Event::fake();

        $data = Page::factory()->active()->advanced()->forRequest();

        from(route('admin.pages.create'))
            ->followingRedirects()
            ->post(route('admin.pages.store'), $data->payload)
            ->assertSuccessful();

        $page = Page::latest('id')->first();

        assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'resource' => $page->resource,
        ]);

        Event::assertDispatched(PageCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the create page page', function () {
        get(route('admin.pages.create'))->assertNotFound();
    });

    test('cannot create a page', function () {
        $data = Page::factory()->active()->forRequest();

        post(route('admin.pages.store'), $data->payload)->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create page page', function () {
        get(route('admin.pages.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a page', function () {
        post(route('admin.pages.store'), [])
            ->assertRedirectToRoute('login');
    });
});
