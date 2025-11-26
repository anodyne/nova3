<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Event;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Pages\Events\PageDeleted;
use Nova\Pages\Livewire\PagesList;
use Nova\Pages\Models\Page;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('pages');

beforeEach(fn () => $this->pages = Page::factory()->count(3)->create());

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'page.delete'));

    test('can delete a page', function () {
        Event::fake();

        $page = $this->pages->first();

        livewire(PagesList::class)
            ->assertCanSeeTableRecords($this->pages)
            ->callAction(TestAction::make(DeleteAction::class)->table($page))
            ->assertCanNotSeeTableRecords([$page])
            ->assertNotified();

        assertDatabaseMissing(Page::class, $page->only('id'));

        Event::assertDispatched(PageDeleted::class);
    });

    test('can bulk delete pages', function () {
        $pages = $this->pages->take(3);

        livewire(PagesList::class)
            ->assertCanSeeTableRecords($pages)
            ->selectTableRecords($pages)
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk())
            ->assertCanNotSeeTableRecords($pages)
            ->assertNotified();

        foreach ($pages as $page) {
            assertDatabaseMissing(Page::class, $page->only('id'));
        }
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot delete pages', function () {
        get(route('admin.pages.index'))
            ->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot delete pages', function () {
        get(route('admin.pages.index'))
            ->assertRedirectToRoute('login');
    });
});
