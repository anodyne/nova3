<?php

declare(strict_types=1);

use Filament\Actions\Testing\TestAction;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Livewire\PagesList;
use Nova\Pages\Models\Page;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('pages');

beforeEach(fn () => $this->pages = Page::factory()->count(5)->create());

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'page.create'));

    test('can view the list pages page', function () {
        get(route('admin.pages.index'))->assertSuccessful();

        livewire(PagesList::class)
            ->assertCanSeeTableRecords($this->pages);
    });

    test('can search pages by name', function () {
        $page = Page::factory()->create(['name' => 'Special test page for search']);

        $pages = $this->pages->push($page);

        livewire(PagesList::class)
            ->searchTable('banana')
            ->assertCountTableRecords(0)
            ->assertCanNotSeeTableRecords($pages)
            ->searchTable('Special test page for search')
            ->assertCountTableRecords(1)
            ->assertCanSeeTableRecords([$page]);
    });

    test('can filter pages by page type', function () {
        livewire(PagesList::class)
            ->filterTable('pageType', false)
            ->assertCanSeeTableRecords($this->pages->whereNull('resource'))
            ->assertCanNotSeeTableRecords($this->pages->whereNotNull('resource'))
            ->filterTable('pageType', true)
            ->assertCanSeeTableRecords($this->pages->whereNotNull('resource'))
            ->assertCanNotSeeTableRecords($this->pages->whereNull('resource'));
    });

    test('can filter pages by status', function () {
        livewire(PagesList::class)
            ->filterTable('status', BasicStatus::Active->value)
            ->assertCanSeeTableRecords($this->pages->where('status', BasicStatus::Active))
            ->assertCanNotSeeTableRecords($this->pages->where('status', '!=', BasicStatus::Active))
            ->filterTable('status', BasicStatus::Inactive->value)
            ->assertCanSeeTableRecords($this->pages->where('status', BasicStatus::Inactive))
            ->assertCanNotSeeTableRecords($this->pages->where('status', '!=', BasicStatus::Inactive));
    });

    test('can filter pages by layout', function () {
        livewire(PagesList::class)
            ->filterTable('layout', 'public')
            ->assertCanSeeTableRecords($this->pages->where('layout', '=', 'public'))
            ->assertCanNotSeeTableRecords($this->pages->where('layout', '!=', 'public'))
            ->filterTable('layout', 'admin')
            ->assertCanSeeTableRecords($this->pages->where('layout', '=', 'admin'))
            ->assertCanNotSeeTableRecords($this->pages->where('layout', '!=', 'admin'));
    });

    describe('can filter pages by http verb', function () {
        test('get', function () {
            livewire(PagesList::class)
                ->removeTableFilters()
                ->filterTable('verb', PageVerb::Get)
                ->assertCountTableRecords(Page::verb(PageVerb::Get)->count());
        });

        test('delete', function () {
            livewire(PagesList::class)
                ->removeTableFilters()
                ->filterTable('verb', PageVerb::Delete)
                ->assertCountTableRecords(Page::verb(PageVerb::Delete)->count());
        });

        test('post', function () {
            livewire(PagesList::class)
                ->removeTableFilters()
                ->filterTable('verb', PageVerb::Post)
                ->assertCountTableRecords(Page::verb(PageVerb::Post)->count());
        });

        test('put', function () {
            livewire(PagesList::class)
                ->removeTableFilters()
                ->filterTable('verb', PageVerb::Put)
                ->assertCountTableRecords(Page::verb(PageVerb::Put)->count());
        });
    });
});

describe('authorized user with page create permissions', function () {
    beforeEach(fn () => signIn(permissions: 'page.create'));

    test('has the correct permissions', function () {
        $page = $this->pages->first();

        livewire(PagesList::class)
            ->assertActionVisible(TestAction::make('preview')->table($page))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($page))
            ->assertActionHidden(TestAction::make('design')->table($page))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($page));
    });
});

describe('authorized user with page delete permissions', function () {
    beforeEach(fn () => signIn(permissions: 'page.delete'));

    test('has the correct permissions', function () {
        $page = $this->pages->first();

        livewire(PagesList::class)
            ->assertActionVisible(TestAction::make('preview')->table($page))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($page))
            ->assertActionHidden(TestAction::make('design')->table($page))
            ->assertActionVisible(TestAction::make(DeleteAction::class)->table($page));
    });
});

describe('authorized user with page update permissions', function () {
    beforeEach(fn () => signIn(permissions: 'page.update'));

    test('has the correct permissions', function () {
        $page = $this->pages->first();

        livewire(PagesList::class)
            ->assertActionVisible(TestAction::make('preview')->table($page))
            ->assertActionVisible(TestAction::make(EditAction::class)->table($page))
            ->assertActionVisible(TestAction::make('design')->table($page))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($page));
    });
});

describe('authorized user with page view permissions', function () {
    beforeEach(fn () => signIn(permissions: 'page.view'));

    test('has the correct permissions', function () {
        $page = $this->pages->first();

        livewire(PagesList::class)
            ->assertActionVisible(TestAction::make('preview')->table($page))
            ->assertActionHidden(TestAction::make(EditAction::class)->table($page))
            ->assertActionHidden(TestAction::make('design')->table($page))
            ->assertActionHidden(TestAction::make(DeleteAction::class)->table($page));
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the manage pages page', function () {
        get(route('admin.pages.index'))->assertNotFound();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the manage pages page', function () {
        get(route('admin.pages.index'))->assertRedirectToRoute('login');
    });
});
